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
                __DIR__.'/Assets/icons' => public_path('vendor/maksuco/icons'),
                __DIR__.'/Assets/flags' => public_path('vendor/maksuco/flags'),
                __DIR__.'/Assets/icons.json' => public_path('vendor/maksuco/icons.json'),
            // 'laravel-assets' is the tag the app's post-update-cmd publishes
            ], ['public', 'laravel-assets']);

            // Optionally: auto-publish without user running vendor:publish manually
            $this->autoPublishAssets();
        }
    }

    protected function autoPublishAssets()
    {
        $source = __DIR__ . '/Extras/img';
        $destination = public_path('vendor/maksuco');
        $this->copyDirectory($source, $destination);
        //effects
        $source = __DIR__ . '/Assets/effects';
        $destination = public_path('vendor/maksuco/effects');
        $this->copyDirectory($source, $destination);
        //icons + flags: referenced in place by the file picker, never re-uploaded
        $this->publishIcons();
    }

    /**
     * Sync icons/flags and the hand-maintained Assets/icons.json that indexes them.
     * copyDirectory skips unchanged files, so repeat artisan calls are cheap.
     */
    protected function publishIcons()
    {
        $assets = __DIR__.'/Assets';
        $public = public_path('vendor/maksuco');

        $this->copyDirectory($assets.'/icons', $public.'/icons');
        $this->copyDirectory($assets.'/flags', $public.'/flags');

        // Add a new svg to Assets/icons or Assets/flags, then list it in icons.json
        if (is_file($assets.'/icons.json')) {
            $source = $assets.'/icons.json';
            $destination = $public.'/icons.json';
            if (!is_file($destination)
                || filesize($destination) !== filesize($source)
                || filemtime($destination) < filemtime($source)) {
                if (!is_dir($public)) {
                    mkdir($public, 0755, true);
                }
                copy($source, $destination);
            }
        }
    }

    protected function copyDirectory($source, $destination)
    {
        if (! is_dir($source)) {
            return;
        }

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
                // Skip files already identical — same size and not older than source
                if (is_file($destinationPath)
                    && filesize($destinationPath) === filesize($sourcePath)
                    && filemtime($destinationPath) >= filemtime($sourcePath)) {
                    continue;
                }
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
