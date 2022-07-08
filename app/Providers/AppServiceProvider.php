<?php

namespace App\Providers;

use App\Models\Channel;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Cache::flush();
        // if(!Cache::has("channels")) {
        //     $channels = Channel::select("title", "link", "image")->get();
        //     Cache::put("channels", $channels);
        // }
        Builder::defaultStringLength(255);
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();

        // URL::forceScheme('https');

    }
}
