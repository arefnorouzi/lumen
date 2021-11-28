<?php

namespace Modules\CategoryPack;

use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

       // include __DIR__.'/routes/web.php';
        $this->app->make('Modules\CategoryPack\CategoryController');

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //dd('It works...');
        $this->loadViewsFrom(__DIR__.'/views', 'category');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/admin/category'),
        ]);
    }
}
