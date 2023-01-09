<?php

namespace App\Providers;

use App\Models\Kanji;
use App\Models\Vocabulary;
use App\Services\Notification\NotificationService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('service.notification', function ($app){
            return new NotificationService();
        });

        App::bind('material.kanji', function ($app){
            return new Kanji();
        });

        App::bind('material.vocabulary', function ($app){
            return new Vocabulary();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
