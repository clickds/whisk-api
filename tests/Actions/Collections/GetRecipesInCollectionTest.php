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
class GetRecipesInCollectionTest extends BaseTestCase
{
    use MockResponses;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_guzzle_makes_correct_request(): void
    {
        $id = 'abc123';
        $uri = '/collection/v2/'.$id.'/recipe';
        $mock = Mockery::mock(Client::class);
        $mock->shouldReceive('request')->once()
            ->with('GET', $uri)
            ->andReturn(new Response(200, [], $this->responseBody()));
        $client = new WhiskApi($mock);

        $response = $client->getRecipesInCollection($id);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('recipes', $response);
    }

    public function test_when_passing_limit(): void
    {
        $id = 'abc123';
        $uri = '/collection/v2/'.$id.'/recipe';
        $mock = Mockery::mock(Client::class);
        $mock->shouldReceive('request')->once()
            ->with('GET', $uri, ['query' => ['limit' => 500]])
            ->andReturn(new Response(200, [], $this->responseBody()));
        $client = new WhiskApi($mock);

        $response = $client->getRecipesInCollection($id, ['limit' => 500]);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('recipes', $response);
    }

    private function responseBody(): string
    {
        return $this->getSupportJson('recipes-in-collection.json');
    }
}
