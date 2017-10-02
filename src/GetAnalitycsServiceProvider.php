<?php

namespace Maksuco\GetAnalitycs;

use Illuminate\Support\ServiceProvider;

class GetAnalitycsServiceProvider extends ServiceProvider
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
        $this->app->bind('maksuco-getanalitycs', function () {
          return new GetAnalitycs();
        });
    }
}
