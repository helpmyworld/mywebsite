<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Validator;
use App\Category;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // (Removed Mix::useManifest override to avoid version/method mismatch)

         Paginator::useBootstrap();

        Schema::defaultStringLength(191);
        Validator::extend('recaptcha', 'App\\Validators\\ReCaptcha@validate');

        view()->composer('layouts.sidebar', function ($view) {
            $view->with('cats', \App\Cat::has('posts')->pluck('name'));
        });

        view()->composer('layouts.frontLayout.front_footer', function ($view) {
            $view->with('posters', \App\Poster::all());
        });

        view()->composer('books.single', function ($view) {
            $view->with('productDetails', \App\Product::has('products')->pluck('name'));
        });

        // Load PHP 8 polyfills for legacy libs calling magic_quotes functions.
        $polyfills = app_path('Support/polyfills.php');
        if (file_exists($polyfills)) {
            require_once $polyfills;
        }


        // Bind categories to the new sidebar/header partials (adjust names to match your includes)
    View::composer([
        'layouts.frontLayout.front_sidebar',
        'layouts.frontLayout.front_header',
        'partials.category_menu',
        'index', // optional: if index prints categories directly
    ], function ($view) {
        $categories = Category::with('categories')
            ->where('parent_id', 0)
            ->get();

        $view->with('categories', $categories);
    });


    }
}
