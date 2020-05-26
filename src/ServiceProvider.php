<?php

namespace ClickDs\WhiskApi;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Support\Arr;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot(): void
    {
    }

    public function register(): void
    {
        $this->app->bind('whisk-api', function ($app, array $parameters = []) {
            $configuration = Arr::get($parameters, 'configuration', []);
            $guzzleConfiguration = Arr::get($parameters, 'guzzleConfiguration', []);

            return WhiskApi::createClient($configuration, $guzzleConfiguration);
        });
    }
}
