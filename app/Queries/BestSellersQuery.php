<?php

namespace App\Queries;

use Illuminate\Support\Facades\DB;

class BestSellersQuery
{
    /**
     * Returns product IDs ordered by units sold in the last 90 days (desc),
     * union with manual best_seller flag, capped to $limit.
     *
     * @param int $limit
     * @return array<int>
     */
    public static function topProductIds(int $limit = 10): array
    {
        // Adjust table/column names to match your schema if different
        $last90 = now()->subDays(90);

        $auto = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->select('order_items.product_id', DB::raw('SUM(order_items.quantity) as units'))
            ->where('orders.created_at', '>=', $last90)
            ->groupBy('order_items.product_id');

        $autoIds = DB::query()
            ->fromSub($auto, 't')
            ->orderByDesc('t.units')
            ->limit($limit)
            ->pluck('t.product_id')
            ->all();

        $manualIds = DB::table('products')
            ->where('is_best_seller', true)
            ->pluck('id')
            ->all();

        // Merge, de-duplicate, keep order (auto first), then pad with manual, cap
        $ordered = array_values(array_unique(array_merge($autoIds, $manualIds)));

        return array_slice($ordered, 0, $limit);
    }
}
