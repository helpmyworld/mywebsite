<?php

namespace App\Queries;

use App\Models\Author;
use App\Models\Product;

class HomepageBlocks
{
    public static function featuredAuthors(int $limit = 4)
    {
        return Author::with(['products' => fn($q) => $q->latest()->limit(3)])
            ->featured()
            ->limit($limit)
            ->get();
    }

    public static function featuredBooks(int $limit = 4)
    {
        return Product::with('authors')
            ->where('is_featured', true)
            ->orderByDesc('featured_at')
            ->orderByDesc('updated_at')
            ->limit($limit)
            ->get();
    }

    public static function newArrivals(int $limit = 4)
    {
        return Product::with('authors')
            ->latest()
            ->limit($limit)
            ->get();
    }
}
