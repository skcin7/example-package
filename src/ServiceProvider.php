<?php

/**
 * Laravel - Example Package
 *
 * @author   Nick Morgan <nick@nicholas-morgan.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  example-package
 */

namespace skcin7\ExamplePackage;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Support\Arr;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Whether or not to defer this provider to be lazy loaded.
     * https://laravel.com/docs/5.8/providers#deferred-providers
     *
     * @var boolean
     */
    protected $defer = true;

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

    /**
     * Merge the given configuration with the existing configuration - supports multi-dimensional arrays.
     * https://medium.com/@koenhoeijmakers/properly-merging-configs-in-laravel-packages-a4209701746d
     *
     * @param  string  $path
     * @param  string  $key
     * @return void
     */
    private function mergeConfigFrom($path, $key)
    {
        $config = $this->app['config']->get($key, []);
        $this->app['config']->set($key, $this->mergeConfig($path, $config));
    }

    /**
     * Merges the configs together and takes multi-dimensional arrays into account.
     *
     * @param  array  $original
     * @param  array  $merging
     * @return array
     */
    private function mergeConfig(array $original, array $merging)
    {
        $array = array_merge($original, $merging);
        foreach($original as $key => $value) {
            if(! is_array($value)) {
                continue;
            }
            if(! Arr::exists($merging, $key)) {
                continue;
            }
            if(is_numeric($key)) {
                continue;
            }
            $array[$key] = $this->mergeConfig($value, $merging[$key]);
        }
        return $array;
    }
}