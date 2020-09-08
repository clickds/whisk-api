<?php

namespace ClickDs\WhiskApi\Tests\Support;

use GuzzleHttp\Client as HttpClient;

trait SandboxClient
{
    public function createUserTokenSandboxClient(string $apiKey, int $version = 2)
    {
        $config = [
            'headers' => [
                'Authorization' => 'Bearer '.$apiKey,
            ],
        ];

        return $this->createGuzzleSandboxClient($config, $version);
    }

    public function createServerTokenSandboxClient(string $apiKey)
    {
        $config = [
            'headers' => [
                'Authorization' => 'Token '.$apiKey,
            ],
        ];

        return $this->createGuzzleSandboxClient($config);
    }

    public function createGuzzleSandboxClient(array $config = [], int $version = 2)
    {
        $baseUri = 'https://api.whisk-dev.com';
        $defaults = [
            'base_uri'    => $baseUri,
            'http_errors' => false,
            'headers'     => [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ];

        $config = array_merge($defaults, $config);

        return new HttpClient($config);
    }
}
