<?php

namespace ClickDs\WhiskApi\Tests\Actions\Collections;

use ClickDs\WhiskApi\Tests\BaseTestCase;
use ClickDs\WhiskApi\Tests\Support\MockResponses;
use ClickDs\WhiskApi\WhiskApi;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;

/**
 * @group Collections
 */
class DeleteCollectionTest extends BaseTestCase
{
    use MockResponses;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_guzzle_makes_correct_request(): void
    {
        $uri = '/v1/1';
        $mock = Mockery::mock(Client::class);
        $mock->shouldReceive('request')->once()
            ->with('DELETE', $uri)
            ->andReturn(new Response(200, [], $this->responseBody()));
        $client = new WhiskApi($mock);

        $response = $client->deleteCollection(1);

        $this->assertNotEmpty($response);
        $this->assertEquals(true, $response['ok']);
    }

    private function responseBody(): string
    {
        return json_encode([
            "ok" => true
        ]);
    }
}
