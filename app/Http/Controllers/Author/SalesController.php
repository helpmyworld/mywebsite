<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Product;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $period    = $request->get('period', 'this');
        $from      = $request->get('from');
        $to        = $request->get('to');
        $productId = $request->get('product_id');

        [$start, $end] = $this->resolvePeriod($period, $from, $to);
        $authorName   = Auth::user()->name;
        $validStatus  = ['Paid','Shipped','Delivered'];

        $base = DB::table('orders_products as op')
            ->join('orders as o', 'o.id', '=', 'op.order_id')
            ->join('products as p', 'p.id', '=', 'op.product_id')
            ->whereIn('o.order_status', $validStatus)
            ->whereBetween('o.created_at', [$start->copy()->startOfDay(), $end->copy()->endOfDay()])
            ->where('p.product_author', $authorName);

        if (!empty($productId)) {
            $base->where('p.id', (int)$productId);
        }

        $rows = (clone $base)->select([
                'p.id as product_id',
                'p.product_name as title',
                'p.royalty_rate as royalty_rate', // <-- NEW
                'o.id as order_id',
                'o.created_at as order_date',
                'o.payment_method',
                'o.platform',
                'o.source',
                'o.name as buyer_name',
                'o.user_email as buyer_email',
                'op.product_qty as qty',
                'op.product_price as unit_price'
            ])
            ->orderBy('o.created_at','desc')
            ->get();

        $totals = ['units'=>0,'revenue'=>0.0,'royalty'=>0.0];
        $defaultRate = 30.0; // fallback if product has no royalty_rate
        $byBook = [];

        foreach ($rows as $r) {
            $units   = (int)$r->qty;
            $revenue = (float)$r->unit_price * $units;
            $rate    = ($r->royalty_rate !== null && $r->royalty_rate !== '') ? (float)$r->royalty_rate : $defaultRate;
            $royalty = $revenue * ($rate/100);

            $totals['units']   += $units;
            $totals['revenue'] += $revenue;
            $totals['royalty'] += $royalty;

            $key = $r->product_id;
            if (!isset($byBook[$key])) {
                $byBook[$key] = [
                    'title'   => $r->title,
                    'units'   => 0,
                    'revenue' => 0.0,
                    'rate'    => $rate,
                    'royalty' => 0.0,
                ];
            }
            $byBook[$key]['units']   += $units;
            $byBook[$key]['revenue'] += $revenue;
            $byBook[$key]['royalty'] += $royalty;
            // keep the latest non-null rate; optional
            $byBook[$key]['rate']     = $rate;
        }

        $byMonth = (clone $base)
            ->selectRaw("
                DATE_FORMAT(o.created_at, '%Y-%m') as ym,
                SUM(op.product_qty) as units,
                SUM(op.product_qty * op.product_price) as revenue
            ")
            ->groupBy('ym')
            ->orderBy('ym', 'asc')
            ->get()
            ->map(function($row){
                return [
                    'month'   => $row->ym,
                    'units'   => (int)$row->units,
                    'revenue' => (float)$row->revenue,
                ];
            })
            ->toArray();

        $byPlatformMethod = (clone $base)
            ->selectRaw("
                COALESCE(o.platform,'') as platform,
                COALESCE(o.payment_method,'') as payment_method,
                SUM(op.product_qty) as units,
                SUM(op.product_qty * op.product_price) as revenue
            ")
            ->groupBy('platform','payment_method')
            ->orderBy('platform')
            ->orderBy('payment_method')
            ->get()
            ->map(function($row){
                return [
                    'platform'       => $row->platform,
                    'payment_method' => $row->payment_method,
                    'units'          => (int)$row->units,
                    'revenue'        => (float)$row->revenue,
                ];
            })
            ->toArray();

        $authorProducts = Product::where('product_author', $authorName)
            ->orderBy('product_name')->get(['id','product_name']);

        $data = [
            'period'  => $this->labelForPeriod($period, $start, $end),
            'start'   => $start,
            'end'     => $end,
            'totals'  => $totals,
            'by_book' => array_values($byBook),
            'filters' => ['available_products' => $authorProducts],
            'details' => $rows,
            'by_month' => $byMonth,
            'by_platform_method' => $byPlatformMethod,
        ];

        return view('author.reports.sales', [
            'data'   => $data,
            'period' => $period
        ]);
    }

    public function csv(Request $request): StreamedResponse
    {
        [$start, $end, $rows] = $this->queryRows($request);
        $filename = 'author-sales-' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->stream(function() use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Order ID','Order Date','Book','Units','Unit Price','Revenue','Buyer','Email','Payment Method','Platform','Source']);
            foreach ($rows as $r) {
                $units   = (int)$r->qty;
                $revenue = (float)$r->unit_price * $units;
                fputcsv($out, [
                    $r->order_id,
                    Carbon::parse($r->order_date)->toDateString(),
                    $r->title,
                    $units,
                    number_format((float)$r->unit_price, 2, '.', ''),
                    number_format($revenue, 2, '.', ''),
                    $r->buyer_name, $r->buyer_email,
                    $r->payment_method, $r->platform, $r->source,
                ]);
            }
            fclose($out);
        }, 200, $headers);
    }

    public function pdf(Request $request)
    {
        [$start, $end, $rows] = $this->queryRows($request);

        $totUnits = 0; $totRevenue = 0.0;
        foreach ($rows as $r) {
            $u = (int)$r->qty;
            $totUnits += $u;
            $totRevenue += $u * (float)$r->unit_price;
        }

        $html = view('author.reports.sales_pdf', [
            'rows'       => $rows,
            'start'      => $start,
            'end'        => $end,
            'totUnits'   => $totUnits,
            'totRevenue' => $totRevenue,
        ])->render();

        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML($html)->setPaper('A4', 'portrait');
        return $pdf->download('author-sales-' . now()->format('Ymd_His') . '.pdf');
    }

    private function resolvePeriod(string $period, ?string $from, ?string $to): array
    {
        $tz = config('reporting.timezone', config('app.timezone', 'Africa/Johannesburg'));
        $now = now($tz);

        if ($period === 'this') return $this->quarterBounds($now->year, $now->quarter, $tz);
        if ($period === 'last') { $last = $now->copy()->subQuarter(); return $this->quarterBounds($last->year, $last->quarter, $tz); }
        if ($period === 'ytd')  return [Carbon::create($now->year, 1, 1, 0, 0, 0, $tz), $now];

        if ($period === 'custom') {
            $s = $from ? Carbon::parse($from, $tz)->startOfDay() : $now->copy()->startOfMonth();
            $e = $to   ? Carbon::parse($to,   $tz)->endOfDay()   : $now;
            return [$s, $e];
        }
        if (preg_match('/^(\d{4})-Q([1-4])$/', $period, $m)) {
            return $this->quarterBounds((int)$m[1], (int)$m[2], $tz);
        }
        return $this->quarterBounds($now->year, $now->quarter, $tz);
    }

    private function quarterBounds(int $year, int $q, string $tz): array
    {
        $starts = [1=>1, 2=>4, 3=>7, 4=>10];
        $s = Carbon::create($year, $starts[$q] ?? 1, 1, 0, 0, 0, $tz);
        $e = $s->copy()->addMonths(3)->subDay()->endOfDay();
        return [$s, $e];
    }

    private function labelForPeriod(string $period, Carbon $start, Carbon $end): string
    {
        if ($period === 'this') return 'This Quarter';
        if ($period === 'last') return 'Last Quarter';
        if ($period === 'ytd')  return 'YTD';
        if ($period === 'custom') return 'Custom';
        if (preg_match('/^\d{4}-Q[1-4]$/', $period)) return $period;
        return $start->format('Y-m-d') . ' to ' . $end->format('Y-m-d');
    }

    private function queryRows(Request $request): array
    {
        $period = $request->get('period', 'this');
        $from   = $request->get('from');
        $to     = $request->get('to');
        $productId = $request->get('product_id');

        [$start, $end] = $this->resolvePeriod($period, $from, $to);

        $authorName  = Auth::user()->name;
        $validStatus = ['Paid','Shipped','Delivered'];

        $q = DB::table('orders_products as op')
            ->join('orders as o', 'o.id', '=', 'op.order_id')
            ->join('products as p', 'p.id', '=', 'op.product_id')
            ->whereIn('o.order_status', $validStatus)
            ->whereBetween('o.created_at', [$start->copy()->startOfDay(), $end->copy()->endOfDay()])
            ->where('p.product_author', $authorName);

        if (!empty($productId)) $q->where('p.id', (int)$productId);

        $rows = $q->select([
                'p.id as product_id',
                'p.product_name as title',
                'p.royalty_rate as royalty_rate', // <-- NEW
                'o.id as order_id',
                'o.created_at as order_date',
                'o.payment_method',
                'o.platform',
                'o.source',
                'o.name as buyer_name',
                'o.user_email as buyer_email',
                'op.product_qty as qty',
                'op.product_price as unit_price'
            ])
            ->orderBy('o.created_at','desc')
            ->get();

        return [$start,$end,$rows];
    }
}
