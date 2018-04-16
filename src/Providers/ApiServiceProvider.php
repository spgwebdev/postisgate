<?php

namespace SeniorProgramming\PostisGate\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class TwitchApiServiceProvider
 * @package Skmetaly\TwitchApi\Providers
 */
class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerServices();
    }

    /**
     *  Boot
     */
    public function boot()
    {
        $this->addConfig();
    }

    /**
     *  Registering services
     */
    private function registerServices()
    {
        $this->app->bind('postisgate', 'SeniorProgramming\PostisGate\Services\ApiService');
    }

    /**
     *  Config publishing
     */
    private function addConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/postisgate.php', 'postisgate'
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}