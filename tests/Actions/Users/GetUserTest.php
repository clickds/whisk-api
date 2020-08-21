<?php

namespace ClickDs\WhiskApi\Tests\Actions\Collections;

use ClickDs\WhiskApi\Tests\BaseTestCase;
use ClickDs\WhiskApi\Tests\Support\MockResponses;
use ClickDs\WhiskApi\Tests\Support\SandboxClient;
use ClickDs\WhiskApi\WhiskApi;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;

/**
 * @group Users
 */
class GetUserTest extends BaseTestCase
{
    use MockResponses;
    use SandboxClient;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * @group sandbox
     */
    public function test_get_user_from_whisk(): void
    {
        $uri = '/user/v2/me';
        $apiKey = getenv('USER_API_KEY');
        $httpClient = $this->createServerTokenSandboxClient($apiKey);
        $client = new WhiskApi($httpClient);

        $response = $client->getUser();

        var_dump($response);
        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('user', $response, 'Could not find user key');
    }


    public function test_guzzle_makes_correct_request(): void
    {
        $uri = '/user/v2/me';
        $mock = Mockery::mock(Client::class);
        $mock->shouldReceive('request')->once()
            ->with('GET', $uri)
            ->andReturn(new Response(200, [], $this->responseBody()));
        $client = new WhiskApi($mock);

        $response = $client->getUser();

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('user', $response, 'Could not find user key');
    }

    private function responseBody(): string
    {
        return $this->getSupportJson('get-user.json');
    }
}
