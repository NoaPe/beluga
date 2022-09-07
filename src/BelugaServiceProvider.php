<?php

namespace NoaPe\Beluga;

use Illuminate\Support\Facades\Route;
use NoaPe\Beluga\Commands\BelugaCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BelugaServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('beluga.php'),
            ], 'config');
        }

        $this->registerRoutes();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'beluga');
        
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function register()
    {
    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'prefix' => config('beluga.prefix'),
            'middleware' => config('beluga.middleware'),
        ];
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('beluga')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_beluga_table')
            ->hasCommand(BelugaCommand::class);
    }
}
