<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Offer;
use App\Services\OfferService;
use App\Models\Category;

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
    public function boot(): void
    {
        View::composer(['partials.offer'], function ($view) {
            $offer = Offer::latest('id')->first();
            $view->with('offer', $offer);
        });

        View::composer('*', function ($view) {
            $categories = Category::with(['products' => function($q){
                $q->latest()->limit(3);
            }])->get();
            $view->with('categories', $categories);
        });
    }
}
