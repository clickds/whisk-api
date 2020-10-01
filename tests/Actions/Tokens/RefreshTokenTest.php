<?php

namespace ClickDs\WhiskApi\Tests\Actions\Tokens;

use ClickDs\WhiskApi\Tests\BaseTestCase;
use ClickDs\WhiskApi\Tests\Support\MockResponses;
use ClickDs\WhiskApi\WhiskApi;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Mockery;

/**
 * @group Tokens
 */
class RefreshTokenTest extends BaseTestCase
{
    use MockResponses;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_guzzle_makes_correct_request(): void
    {
        $clientId = "client_id";
        $clientSecret = "client_secret";
        $grantType = "refresh_token";
        $refreshToken = "old_refresh_token";

        $uri = 'https://login.whisk.com/oauth/v2/token';
        $mock = Mockery::mock(Client::class);
        $parameters = [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => $grantType,
            'refresh_token' => $refreshToken,
        ];
        $mock->shouldReceive('request')->once()
            ->with('POST', $uri, \Mockery::on(function ($argument) {
                return is_array($argument) && array_key_exists('form_params', $argument)
                    && array_key_exists('handler', $argument);
            }))
            ->andReturn(new Response(200, [], $this->responseBody()));
        $client = new WhiskApi($mock);

        $response = $client->refreshToken($parameters);

        $this->assertNotEmpty($response);
        $this->assertEquals('access_token', $response['access_token']);
    }

    private function responseBody(): string
    {
        return json_encode([
            "access_token" => "access_token",
            "expires_in" => 86400,
            "scope" => "cookbook:write shopping_list:write user.preferences:write user.profile:read",
            "token_type" => "Bearer",
            "refresh_token" => "refresh_token",
            "new_user" => false,
        ]);
    }
}
