<?php

namespace App\Queries;

use Illuminate\Support\Arr;

class FeaturedCategoriesByName
{
    /**
     * Resolve categories by exact name match, keeping config order.
     * Adjust \App\Models\Category and column names to your app.
     */
    public static function get(int $limit = 4)
    {
        $names = config('featured.categories_by_name', []);
        if (empty($names)) {
            return collect();
        }

        $Category = app(\App\Models\Category::class);

        $map = $Category->whereIn('name', $names)->get()->keyBy('name');

        $ordered = [];
        foreach (Arr::wrap($names) as $n) {
            if ($map->has($n)) {
                $ordered[] = $map->get($n);
            }
            if (count($ordered) >= $limit) break;
        }
        return collect($ordered);
    }
}
