<?php

namespace ClickDs\WhiskApi;

use ClickDs\WhiskApi\Exceptions\InvalidConfigurationException;
use GuzzleHttp\HandlerStack;

class Configuration
{
    public const TOKEN_TYPES = [
        'client',
        'server',
        'user_access',
    ];

    private string $baseUri;
    private array $headers;
    private bool $httpErrors;
    private HandlerStack $handlerStack;

    /**
     * @param array{ base_uri: string, http_errors: bool, api_token: string, token_type: string, handler_stack: HandlerStack } $parameters
     */
    public function __construct(array $parameters = [])
    {
        $apiToken = $this->fetchApiToken($parameters);
        $tokenType = $this->fetchTokenType($parameters);
        $this->headers = $this->buildHeaders($apiToken, $tokenType);
        $this->baseUri = $this->fetchKeyFromArray($parameters, 'base_uri', 'https://graph.whisk.com');
        $this->httpErrors = $this->fetchKeyFromArray($parameters, 'http_errors', false);
        $this->handlerStack = $this->buildHandlerStack($parameters);
    }

    public function guzzleConfig(): array
    {
        return [
            'base_uri'    => $this->baseUri,
            'http_errors' => $this->httpErrors,
            'headers'     => $this->headers,
            'handler'     => $this->handlerStack,
        ];
    }

    private function buildHandlerStack(array $parameters)
    {
        $handlerStack = $this->fetchKeyFromArray($parameters, 'handler_stack', null);
        if (is_null($handlerStack)) {
            return HandlerStack::create();
        }

        return $handlerStack;
    }

    private function buildHeaders(string $apiToken, string $tokenType): array
    {
        $headers = [
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ];
        $authToken = $tokenType === 'user_access' ? 'Bearer ' : 'Token ';
        $authToken .= $apiToken;
        $headers['Authorization'] = $authToken;

        return $headers;
    }

    private function fetchTokenType(array $parameters): string
    {
        $tokenType = $this->fetchKeyFromArray($parameters, 'token_type', null);
        if (!in_array($tokenType, self::TOKEN_TYPES)) {
            throw new InvalidConfigurationException('token_type must be a valid token type.');
        }

        return $tokenType;
    }

    private function fetchApiToken(array $parameters): string
    {
        $apiToken = $this->fetchKeyFromArray($parameters, 'api_token', null);
        if (is_null($apiToken)) {
            throw new InvalidConfigurationException('api_token must be provided.');
        }

        return $apiToken;
    }

    private function fetchKeyFromArray(array $array, string $key, $default = null)
    {
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        return $default;
    }
}
