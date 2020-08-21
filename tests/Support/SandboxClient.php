<?php

namespace ClickDs\WhiskApi\Tests\Support;

use GuzzleHttp\Client as HttpClient;

trait SandboxClient
{
    public function createUserTokenSandboxClient(string $apiKey)
    {
        $config = [
            'headers' => [
                'Authorization' => 'Bearer '.$apiKey,
            ],
        ];

        return $this->createGuzzleSandboxClient($config);
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

    public function createGuzzleSandboxClient(array $config = [])
    {
        $defaults = [
            'base_uri'    => 'https://api.whisk-dev.com',
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
