<?php

namespace Travelience\Helpers;

use Illuminate\Support\ServiceProvider;
use Route;

class HelpersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
             
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        require_once __DIR__ . '/Helpers.php';
    }
}
