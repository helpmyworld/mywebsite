<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'photo_path',
        'bio',
        'is_featured',
        'featured_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'featured_at' => 'datetime',
    ];

    // Relationships
    public function products()
    {
        // Adjust 'App\Models\Product' if your namespace differs
        return $this->belongsToMany(Product::class, 'author_product', 'author_id', 'product_id');
    }

    // Helpers
    protected static function booted()
    {
        static::creating(function ($author) {
            if (empty($author->slug)) {
                $author->slug = static::uniqueSlug($author->name);
            }
            if ($author->is_featured && empty($author->featured_at)) {
                $author->featured_at = now();
            }
        });

        static::updating(function ($author) {
            if ($author->isDirty('name') && empty($author->slug)) {
                $author->slug = static::uniqueSlug($author->name);
            }
            if ($author->isDirty('is_featured') && $author->is_featured && empty($author->featured_at)) {
                $author->featured_at = now();
            }
        });
    }

    public static function uniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;
        while (static::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    // Scopes
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
            ->orderByDesc('featured_at')
            ->orderByDesc('created_at');
    }
}
