<?php

namespace ClickDs\WhiskApi;

use ClickDs\WhiskApi\Actions\Feed;
use ClickDs\WhiskApi\Actions\Recipes;
use ClickDs\WhiskApi\Exceptions\InvalidConfigurationException;
use GuzzleHttp\Client as HttpClient;

class WhiskApi
{
    use MakesHttpRequests;
    use Recipes;
    use Feed;

    private const DEFAULT_GUZZLE_CONFIG = [
        'base_uri' => 'https://graph.whisk.com',
        'http_errors' => false,
        'headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ],
    ];

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var string
     */
    private $version;

    public function __construct(HttpClient $httpClient, string $version = 'v1')
    {
        $this->httpClient = $httpClient;
        $this->version = $version;
    }

    private function getVersion(): string
    {
        return $this->version;
    }

    private function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }

    /**
     * @param array<string> $configuration
     * @param array<mixed> $guzzleConfig
     */
    public static function createClient(array $configuration, array $guzzleConfig = []): HttpClient
    {
        $difference = array_diff(['api_token', 'token_type'], array_keys($configuration));
        if (count($difference) !== 0) {
            throw new InvalidConfigurationException('api_token must be provided.');
        }

        $apiToken = $configuration['api_token'];
        $tokenType = $configuration['token_type'];

        $authToken = $tokenType === 'user_access' ? 'Bearer ' : 'Token ';
        $authToken .= $apiToken;

        $defaultConfig = static::DEFAULT_GUZZLE_CONFIG;
        $defaultConfig['headers']['Authorization'] = $authToken;
        $clientConfig = array_merge($defaultConfig, $guzzleConfig);

        return new HttpClient($clientConfig);
    }
}
