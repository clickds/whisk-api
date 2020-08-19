<?php

namespace ClickDs\WhiskApi\Tests\Actions;

use ClickDs\WhiskApi\Tests\BaseTestCase;
use ClickDs\WhiskApi\Tests\Support\MockResponses;
use ClickDs\WhiskApi\WhiskApi;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;

/**
 * @group Collections
 */
class CreateCollectionTest extends BaseTestCase
{
    use MockResponses;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_guzzle_makes_correct_request(): void
    {
        $uri = '/v1/collections';
        $mock = Mockery::mock(Client::class);
        $parameters = ['name' => 'My collection'];
        $mock->shouldReceive('request')->once()
            ->with('POST', $uri, ['form_params' => $parameters])
            ->andReturn(new Response(200, [], $this->responseBody()));
        $client = new WhiskApi($mock);

        $response = $client->createCollection($parameters);

        $this->assertNotEmpty($response);
        $this->assertEquals('97f77cceca5d11e7ae7e42010a9a0035', $response['id']);
    }

    private function responseBody(): string
    {
        return $this->getSupportJson('create-collection.json');
    }
}
