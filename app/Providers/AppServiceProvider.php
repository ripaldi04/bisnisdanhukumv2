<?php

namespace App\Providers;

use App\Models\SubModule;
use App\Observers\SubModuleObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        Model::unguard();
        SubModule::observe(SubModuleObserver::class);
        // URL::forceScheme('https');

    }
}
