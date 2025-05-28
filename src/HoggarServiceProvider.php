<?php

namespace Hoggarcrud\Hoggar;

use Illuminate\Support\ServiceProvider;


class HoggarServiceProvider extends ServiceProvider
{
   
    public function register(): void
    {
       $this->publishes([
            __DIR__.'/../config/hoggar.php' => config_path('hoggar.php'),
        ], 'hoggar-config');

        $this->mergeConfigFrom(
            __DIR__.'/../config/hoggar.php', 'hoggar'
        );
    }

   
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->commands([
            \Hoggarcrud\Hoggar\Commands\HoggarCommand::class,
            \Hoggarcrud\Hoggar\Commands\CreateUser::class,
        ]);
    }
}
