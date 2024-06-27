<?php

namespace App\Providers;

use App\Helpers\WaHelper;
use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // \URL::forceScheme('https');
        $helperInit = [
            new GeneralHelper(),
            new WaHelper()
        ];

        Vite::macro('image', fn (string $asset) => $this->asset("resources/images/{$asset}"));
    }
}
