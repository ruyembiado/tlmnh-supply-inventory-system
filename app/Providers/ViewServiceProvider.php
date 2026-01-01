<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Item;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }   

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::share('items', Item::orderBy('item_name', 'asc')->get());
    }
}
