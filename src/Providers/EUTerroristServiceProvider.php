<?php

namespace Jota\EUTerroristList\Providers;

use Illuminate\Support\ServiceProvider;
use Jota\EUTerroristList\Classes\EUTerroristList;
class EUTerroristServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() : void
    {
        $this->app->bind('EUTerroristList', function () {
            return new EUTerroristList();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() : void
    {
        $this->publishes([
            __DIR__ . '/../../config/euterrorist.php' => config_path('euterrorist.php'),
        ]);
    }
}
