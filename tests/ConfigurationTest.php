<?php

namespace ClickDs\WhiskApi\Tests;

use ClickDs\WhiskApi\Configuration;
use ClickDs\WhiskApi\Exceptions\InvalidConfigurationException;
use ClickDs\WhiskApi\WhiskApi;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    public function test_it_throws_an_exception_if_api_token_is_missing()
    {
        $config = [
            'token_type' => 'server',
        ];
        $this->expectException(InvalidConfigurationException::class);

        new Configuration($config);
    }

    public function test_it_throws_an_exception_if_api_key_is_missing()
    {
        $config = [
            'api_token' => 'abc',
        ];
        $this->expectException(InvalidConfigurationException::class);

        new Configuration($config);
    }

    public function test_when_token_type_is_server()
    {
        $apiToken = 'abc';
        $config = new Configuration([
            'api_token'  => $apiToken,
            'token_type' => 'server',
        ]);

        $client = WhiskApi::createClient($config);

        $headerConfig = $client->getConfig('headers');

        $this->assertEquals($headerConfig['Authorization'], 'Token ' . $apiToken);
    }

    public function test_when_token_type_is_client()
    {
        $apiToken = 'abc';
        $config = new Configuration([
            'api_token'  => $apiToken,
            'token_type' => 'client',
        ]);

        $client = WhiskApi::createClient($config);

        $headerConfig = $client->getConfig('headers');

        $this->assertEquals($headerConfig['Authorization'], 'Token ' . $apiToken);
    }

    public function test_when_token_type_is_user_access()
    {
        $apiToken = 'abc';
        $config = new Configuration([
            'api_token'  => $apiToken,
            'token_type' => 'user_access',
        ]);

        $client = WhiskApi::createClient($config);

        $headerConfig = $client->getConfig('headers');

        $this->assertEquals($headerConfig['Authorization'], 'Bearer ' . $apiToken);
    }
}
