<?php

namespace ExamplePackage;

use Illuminate\Support\ServiceProvider;

class ExamplePackageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/example-package.php';
        $this->publishes([$configPath => config_path('example-package.php')], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/example-package.php';
        $this->mergeConfigFrom($configPath, 'example-package');
    }
}