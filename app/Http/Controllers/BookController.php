<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Schema;

class BookController extends Controller
{
    /**
     * Books listing that adapts to whatever columns your products table has.
     * It now correctly prefers: product_name, product_author, product_image, description, slug.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Helper: does a column exist on `products`?
        $has = function (string $col): bool {
            try {
                return Schema::hasColumn('products', $col);
            } catch (\Throwable $e) {
                return false;
            }
        };

        // SEARCH (supports your schema: product_name / product_author)
        if ($s = $request->get('q')) {
            $like = '%' . $s . '%';
            $query->where(function ($q) use ($like, $has) {
                $added = false;

                // Titles / names
                foreach (['product_name', 'title', 'name'] as $col) {
                    if ($has($col)) { $q->orWhere($col, 'like', $like); $added = true; }
                }

                // Authors
                foreach (['product_author', 'author_name'] as $col) {
                    if ($has($col)) { $q->orWhere($col, 'like', $like); $added = true; }
                }

                // Fallback: description
                if (!$added && $has('description')) {
                    $q->orWhere('description', 'like', $like);
                }
            });
        }

        // CATEGORY FILTER (kept flexible)
        if ($cat = $request->get('category')) {
            $query->where(function ($q) use ($cat, $has) {
                foreach (['category_id', 'category', 'category_slug'] as $col) {
                    if ($has($col)) $q->orWhere($col, $cat);
                }
            });
        }

        // SORT
        switch ($request->get('sort', 'new')) {
            case 'popular':
                if ($has('sales_count'))       { $query->orderByDesc('sales_count'); }
                elseif ($has('id'))            { $query->orderByDesc('id'); }
                break;
            case 'price_asc':
                if     ($has('price'))         { $query->orderBy('price'); }
                elseif ($has('id'))            { $query->orderBy('id'); }
                break;
            case 'price_desc':
                if     ($has('price'))         { $query->orderByDesc('price'); }
                elseif ($has('id'))            { $query->orderByDesc('id'); }
                break;
            default: // 'new'
                if     ($has('created_at'))    { $query->latest(); }
                elseif ($has('id'))            { $query->orderByDesc('id'); }
        }

        // Paginate
        $books = $query->paginate(12)->appends($request->query());

        // Map safe display fields so Blade never touches missing properties
        $books->setCollection(
            $books->getCollection()->map(function ($item) {
                $get = function ($obj, $key, $default = null) {
                    if (is_array($obj))  return $obj[$key]  ?? $default;
                    if (is_object($obj)) return $obj->{$key} ?? $default;
                    return $default;
                };

                $id     = $get($item, 'id');
                // Prefer your schema columns first
                $title  = $get($item, 'product_name')
                       ?? $get($item, 'title')
                       ?? $get($item, 'name')
                       ?? 'Untitled';

                $slug   = $get($item, 'slug'); // may be null
                $cover  = $get($item, 'image')            // your legacy image field
                       ?? $get($item, 'product_image')
                       ?? $get($item, 'cover_url');

                $blurb  = $get($item, 'description')
                       ?? $get($item, 'blurb');

                $author = $get($item, 'product_author')
                       ?? $get($item, 'author_name');

                // Detail URL (prefer slug if present)
                $detailUrl = $slug ? url('/product/' . $slug) : url('/product/' . $id);

                // Attach virtuals for the view
                $item->display_title  = $title;
                $item->display_author = $author;
                $item->display_blurb  = $blurb;
                $item->display_cover  = $cover;
                $item->display_url    = $detailUrl;

                return $item;
            })
        );

        // If you don’t maintain categories separately, pass empty list
        $categories = collect();

        return view('books.index', compact('books', 'categories'));
    }

    /**
     * Back-compat: if any routes still call BookController@books
     */
    public function books(Request $request)
    {
        return $this->index($request);
    }
}
