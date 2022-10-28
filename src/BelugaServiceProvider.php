<?php

namespace NoaPe\Beluga;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use NoaPe\Beluga\Auth\Middleware\UserHasBelugaAdministrationPermission;
use NoaPe\Beluga\Console\InstallBelugaPackage;
use NoaPe\Beluga\Console\MakeControllerCommand;
use NoaPe\Beluga\Console\MakeMigrationCommand;
use NoaPe\Beluga\Console\MakeShellCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BelugaServiceProvider extends PackageServiceProvider
{
    /**
     * Policies
     *
     * @var array
     */
    protected $policies = [
        Http\Shells\Permission::class => Http\Policies\PermissionPolicy::class,
        Http\Models\Table::class => Http\Policies\TablePolicy::class,
        Http\Models\Group::class => Http\Policies\GroupPolicy::class,
        Http\Models\Data::class => Http\Policies\DataPolicy::class,
    ];

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallBelugaPackage::class,
                MakeControllerCommand::class,
                MakeMigrationCommand::class,
                MakeShellCommand::class,
            ]);
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('beluga.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../config/permissions.php' => config_path('permissions.php'),
            ], 'permissions');
        }

        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('assets/beluga'),
        ], 'assets');

        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'beluga');
        $this->mergeConfigFrom(__DIR__.'/../config/internal.php', 'beluga.internal');

        $this->registerRoutes();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'beluga');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->registerPolicies();

        ShellComponentProvider::register();
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
            'middleware' => array_merge(
                config('beluga.middleware'),
                [UserHasBelugaAdministrationPermission::class]
            ),
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
            ->hasMigration('create_beluga_table');
    }

    protected function registerPolicies()
    {
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}
