<?php

namespace ClickDs\WhiskApi\Tests\Support;

use ClickDs\WhiskApi\Configuration;
use ClickDs\WhiskApi\WhiskApi;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

trait MockResponses
{
    private function createHandlerStack(array $responses): HandlerStack
    {
        $mock = new MockHandler($responses);

        return HandlerStack::create($mock);
    }

    private function createApiClientWithMockedResponses(array $responses, string $tokenType = 'server'): WhiskApi
    {
        $handler = $this->createHandlerStack($responses);
        $config = new Configuration([
            'api_token'     => 'abc',
            'token_type'    => $tokenType,
            'handler'       => $handler,
        ]);

        return WhiskApi::createApiClient($config);
    }
}
