<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Services\AuthorSalesService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Dompdf\Dompdf;

class AuthorSalesController extends Controller
{
    protected function opts(Request $request): array
    {
        $period   = $request->get('period', 'this');
        $allowed  = ['this','last','ytd','custom'];
        if (preg_match('/^\d{4}-Q[1-4]$/', $period)) {
            // ok
        } elseif (!in_array($period, $allowed, true)) {
            $period = 'this';
        }

        $productId = $request->filled('product_id') ? (int)$request->get('product_id') : null;

        return [
            'period'     => $period,
            'from'       => $request->get('from'),
            'to'         => $request->get('to'),
            'product_id' => $productId,
        ];
    }

    public function index(Request $request, AuthorSalesService $svc)
    {
        $data = $svc->report($this->opts($request));
        $period = $this->opts($request)['period'];

        return view('author.sales.index', compact('data','period'));
    }

    public function exportCsv(Request $request, AuthorSalesService $svc)
    {
        $opts = $this->opts($request);
        $data = $svc->report($opts);

        $who = Str::slug($request->user()->name ?? 'author');
        $per = Str::slug($data['period']);
        $filename = "sales_{$who}_{$per}.csv";

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Cache-Control'       => 'no-store, no-cache',
        ];

        return response()->stream(function () use ($data) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Period', $data['period']]);
            fputcsv($out, ['From', $data['start']->toDateString()]);
            fputcsv($out, ['To',   $data['end']->toDateString()]);
            fputcsv($out, ['Currency', $data['currency']]);
            fputcsv($out, []);
            fputcsv($out, ['Book', 'Units', 'Revenue (ZAR)', 'Rate %', 'Royalty (ZAR)']);
            foreach ($data['by_book'] as $row) {
                fputcsv($out, [
                    $row['title'],
                    $row['units'],
                    number_format($row['revenue'], 2, '.', ''),
                    number_format($row['rate'], 2, '.', ''),
                    number_format($row['royalty'], 2, '.', ''),
                ]);
            }
            fputcsv($out, []);
            fputcsv($out, ['TOTAL', $data['totals']['units'], number_format($data['totals']['revenue'], 2, '.', ''), '', number_format($data['totals']['royalty'], 2, '.', '')]);
            fclose($out);
        }, 200, $headers);
    }

    public function exportPdf(Request $request, AuthorSalesService $svc)
    {
        $opts = $this->opts($request);
        $data = $svc->report($opts);

        $html = view('author.sales.pdf', [
            'data'   => $data,
            'author' => $request->user(),
        ])->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $who = \Illuminate\Support\Str::slug($request->user()->name ?? 'author');
        $per = \Illuminate\Support\Str::slug($data['period']);
        $filename = "sales_{$who}_{$per}.pdf";

        return response($dompdf->output(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Cache-Control'       => 'no-store, no-cache',
        ]);
    }
}
