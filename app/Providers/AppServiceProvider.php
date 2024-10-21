<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Offer;
use App\Services\OfferService;
use App\Models\Category;
use App\Services\SocialMediaService;

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
        View::composer('*', function($view){
            $allSocialMedia = (new SocialMediaService)->get();
            $view->with('allSocialMedia', $allSocialMedia);
        });

        View::composer(['partials.offer'], function ($view) {
            $offer = Offer::where('is_active', true)->latest('id')->first();
            $view->with('offer', $offer);
        });

        View::composer('*', function ($view) {
            $categories = Category::with(['products','products.variants', 'products.variants.subOptions', 'products.variants.subOptions.option'])->get();
            $view->with('categories', $categories);
        });
    }
}
