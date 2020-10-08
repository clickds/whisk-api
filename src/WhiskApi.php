<?php

namespace ClickDs\WhiskApi;

use ClickDs\WhiskApi\Actions\Collections;
use ClickDs\WhiskApi\Actions\Feed;
use ClickDs\WhiskApi\Actions\Recipes;
use ClickDs\WhiskApi\Actions\Tokens;
use ClickDs\WhiskApi\Actions\Users;
use ClickDs\WhiskApi\Exceptions\InvalidConfigurationException;
use GuzzleHttp\Client as HttpClient;

class WhiskApi
{
    use MakesHttpRequests;
    use Collections;
    use Feed;
    use Recipes;
    use Tokens;
    use Users;

    private const DEFAULT_GUZZLE_CONFIG = [
        'base_uri'    => 'https://graph.whisk.com',
        'http_errors' => false,
        'headers'     => [
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ],
    ];

    /**
     * @var HttpClient
     */
    private $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    private function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }

    /**
     * @param Configuration $configuration
     */
    public static function createClient(Configuration $configuration): HttpClient
    {
        return new HttpClient($configuration->guzzleConfig());
    }
}
