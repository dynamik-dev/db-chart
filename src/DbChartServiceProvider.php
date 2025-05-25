<?php

namespace Dynamik\DbChart;

use Closure;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class DbChartServiceProvider extends PackageServiceProvider
{
    public static ?Closure $authorized = null;

    public static function authorizeUsing(Closure $closure): void
    {
        self::$authorized = $closure;
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('db-chart')
            ->hasConfigFile()
            ->hasViews()
            ->hasRoutes('web')
            ->hasAssets();
    }

    public function packageBooted(): void
    {
        $this->publishes([
            __DIR__.'/../dist' => public_path('vendor/db-chart'),
        ], 'db-chart-assets');
    }
}
