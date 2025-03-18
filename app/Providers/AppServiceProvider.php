<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Existing code
        Paginator::defaultView('vendor.pagination.tailwind');
        Paginator::defaultSimpleView('vendor.pagination.simple-tailwind');

        // Register components
        Blade::component('layout', \App\View\Components\Layout::class);
        Blade::component('navbar', \App\View\Components\Navbar::class);
        Blade::component('footer', \App\View\Components\Footer::class);
        Blade::component('admin-layout', \App\View\Components\AdminLayout::class);
    }
}
