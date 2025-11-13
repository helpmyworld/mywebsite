<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

class HomepageCache
{
    public static function remember(string $key, \Closure $callback, int $minutes = 15)
    {
        $key = 'homepage:' . $key;
        return Cache::remember($key, now()->addMinutes($minutes), $callback);
    }

    public static function forget(string $key): void
    {
        Cache::forget('homepage:' . $key);
    }
}
