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
                __DIR__.'/Extras/img' => public_path('vendor/maksuco'),
            ], 'public');

            // Optionally: auto-publish without user running vendor:publish manually
            $this->autoPublishAssets();
        }
    }

    protected function autoPublishAssets()
    {
        $source = __DIR__ . '/Extras/img';
        $destination = public_path('vendor/maksuco');

        $this->copyDirectory($source, $destination);
    }

    protected function copyDirectory($source, $destination)
    {
        // Ensure the destination directory exists
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        // Iterate through the source directory
        foreach (scandir($source) as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $sourcePath = $source . '/' . $file;
            $destinationPath = $destination . '/' . $file;

            if (is_dir($sourcePath)) {
                // Recursively copy subdirectories
                $this->copyDirectory($sourcePath, $destinationPath);
            } else {
                // Copy files
                copy($sourcePath, $destinationPath);
            }
        }
    }

    public function register()
    {
        $this->app->bind('maksuco-helpers', function () {
            return new Helpers();
        });
    }
}
