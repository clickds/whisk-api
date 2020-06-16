<?php

namespace ClickDs\WhiskApi;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

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
            $guzzleClient = WhiskApi::createClient($configuration, $guzzleConfiguration);

            $version = Arr::get($parameters, 'version', 'v1');

            return new WhiskApi($guzzleClient, $version);
        });
    }
}
