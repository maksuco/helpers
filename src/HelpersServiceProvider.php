<?php

namespace Maksuco\Helpers;

use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      // $this->publishes([
      //   __DIR__ . '/config/helpers.php' => config_path('helpers.php')
      // ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('maksuco-helpers', function () {
          return new Helpers();
        });
    }
}
