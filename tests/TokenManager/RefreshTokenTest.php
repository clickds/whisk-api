<?php

namespace ClickDs\WhiskApi\Tests\TokenManager;

use ClickDs\WhiskApi\Tests\BaseTestCase;
use ClickDs\WhiskApi\TokenManager;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;

/**
 * @group TokenManager
 */
class RefreshTokenTest extends BaseTestCase
{
    public function test_fetching_access_token()
    {
        $uri = 'https://login.whisk.com/oauth/v2/token';
        $mock = Mockery::mock(Client::class);
        $whiskCode = 'whisk_code';
        $clientId = 'abc';
        $clientSecret = 'def';
        $refreshToken = 'refresh_token';
        $mock->shouldReceive('request')->once()
            ->with('POST', $uri, ['form_params' => [
                'client_id'     => $clientId,
                'client_secret' => $clientSecret,
                'grant_type'    => 'refresh_token',
                'refresh_token' => $refreshToken,
            ]])
            ->andReturn(new Response(200, [], json_encode([
                'access_token'  => 'my-access-token',
                'expires_in'    => 86400,
                'scope'         => 'cookbook:write shopping_list:write user.preferences:write user.profile:read',
                'token_type'    => 'Bearer',
                'refresh_token' => 'my-refresh-token',
                'new_user'      => false,
            ])));
        $tokenManager = new TokenManager($clientId, $clientSecret, $mock);

        $result = $tokenManager->refreshToken($refreshToken);

        $this->assertEquals('my-access-token', $result['access_token']);
        $this->assertEquals('my-refresh-token', $result['refresh_token']);
    }
}
