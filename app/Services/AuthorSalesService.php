<?php

namespace App\Services;

use App\Support\Quarter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthorSalesService
{
    public function report(array $opts = []): array
    {
        $period   = $opts['period'] ?? 'this';
        $from     = $opts['from']   ?? null;
        $to       = $opts['to']     ?? null;
        $product  = $opts['product_id'] ?? null;

        [$start, $end, $label] = Quarter::bounds($period, $from, $to);
        $authorId   = Auth::id();
        $paid       = config('reporting.paid_statuses', ['Paid','Completed']);
        $defaultRate = (float) config('reporting.default_royalty_rate', 35.0);
        $platformFee = (float) config('reporting.platform_fee_rate', 0.0) / 100.0;

        // Base aggregates
        $q = DB::table('orders_products as op')
            ->join('orders as o', 'o.id', '=', 'op.order_id')
            ->join('products as p', 'p.id', '=', 'op.product_id')
            ->where('p.user_id', $authorId)
            ->whereIn('o.order_status', $paid)
            ->whereBetween('o.created_at', [$start, $end]);

        if ($product) $q->where('op.product_id', (int)$product);

        $rows = $q->groupBy('op.product_id', 'p.product_name', 'p.royalty_rate', 'op.product_id')
            ->selectRaw('op.product_id as product_id, p.product_name as title, COALESCE(p.royalty_rate, ?) as rate', [$defaultRate])
            ->selectRaw('SUM(op.product_qty) as units')
            ->selectRaw('SUM(op.product_qty * op.product_price) as revenue')
            ->get()
            ->keyBy('product_id');

        // Refunds within the same date range
        $refunds = DB::table('refunds as r')
            ->join('orders_products as op', 'op.id', '=', 'r.order_product_id')
            ->join('products as p', 'p.id', '=', 'op.product_id')
            ->where('p.user_id', $authorId)
            ->whereBetween('r.refunded_at', [$start, $end])
            ->when($product, fn($qq) => $qq->where('op.product_id', (int)$product))
            ->groupBy('op.product_id')
            ->selectRaw('op.product_id, SUM(r.units) as units_refunded, SUM(r.amount) as amount_refunded')
            ->get()
            ->keyBy('product_id');

        $byBook = [];
        $totUnits = 0; $totRevenue = 0.0; $totRoyalty = 0.0;

        foreach ($rows as $pid => $r) {
            $units = (int)$r->units;
            $revenue = (float)$r->revenue;

            if ($refunds->has($pid)) {
                $units   -= (int)$refunds[$pid]->units_refunded;
                $revenue -= (float)$refunds[$pid]->amount_refunded;
                if ($units < 0) $units = 0;
                if ($revenue < 0) $revenue = 0.0;
            }

            $netRevenue = $platformFee > 0 ? $revenue * (1 - $platformFee) : $revenue;
            $rate = (float)$r->rate;
            $royalty = round($netRevenue * ($rate / 100), 2);

            $byBook[] = [
                'product_id' => (int)$pid,
                'title'      => $r->title,
                'units'      => $units,
                'revenue'    => round($revenue, 2),
                'rate'       => round($rate, 2),
                'royalty'    => $royalty,
            ];

            $totUnits += $units;
            $totRevenue += $revenue;
            $totRoyalty += $royalty;
        }

        $products = DB::table('products')->where('user_id', $authorId)->orderBy('product_name')->get(['id','product_name']);

        return [
            'period'   => $label,
            'start'    => $start,
            'end'      => $end,
            'currency' => 'ZAR',
            'filters'  => [
                'product_id' => $product ? (int)$product : null,
                'available_products' => $products,
            ],
            'totals'   => [
                'units'   => $totUnits,
                'revenue' => round($totRevenue, 2),
                'royalty' => round($totRoyalty, 2),
            ],
            'by_book'  => $byBook,
        ];
    }
}
