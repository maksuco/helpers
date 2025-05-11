<?php

namespace Maksuco\Helpers;

use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Only publish when running artisan commands (not on every web load)
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/Extras/avatars' => public_path('vendor/maksuco'),
            ], 'public');

            // Optionally: auto-publish without user running vendor:publish manually
            $this->autoPublishAssets();
        }
    }

    protected function autoPublishAssets()
    {
        // Laravel's vendor:publish handles publishing — but if you want truly automatic (copy assets programmatically)
        $source = __DIR__.'/Extras/avatars';
        $destination = public_path('vendor/maksuco');

        if (! is_dir($destination)) {
            // Ensure the directory exists
            mkdir($destination, 0755, true);
        }

        foreach (scandir($source) as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            copy($source . '/' . $file, $destination . '/' . $file);
        }
    }

    public function register()
    {
        $this->app->bind('maksuco-helpers', function () {
            return new Helpers();
        });
    }
}
