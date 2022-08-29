<?php

namespace NoaPe\Beluga;

use NoaPe\Beluga\Commands\BelugaCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BelugaServiceProvider extends PackageServiceProvider
{

    public function boot()
    {
        //
    }

    public function register()
    {
        //
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
