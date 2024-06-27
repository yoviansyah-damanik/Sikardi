<?php

namespace App\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AliasServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('NumberHelper', \App\Helpers\NumberHelper::class);
        $loader->alias('GeneralHelper', \App\Helpers\GeneralHelper::class);
        $loader->alias('PDF', \Barryvdh\DomPDF\Facade\Pdf::class);
    }
}
