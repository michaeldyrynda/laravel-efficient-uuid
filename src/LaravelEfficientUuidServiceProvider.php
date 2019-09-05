<?php

namespace Dyrynda\Database;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;

class LaravelEfficientUuidServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Blueprint::macro('efficientUuid', function ($column) {
            $this->addColumn('efficientUuid', $column);
        });
    }
}
