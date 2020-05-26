<?php

namespace ClickDs\WhiskApi;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot(): void
    {
    }

    public function register(): void
    {
        $this->app->bind('whisk-api', function (array $configuration = [], array $guzzleConfiguration = []) {
            return WhiskApi::createClient($configuration, $guzzleConfiguration);
        });
    }
}
