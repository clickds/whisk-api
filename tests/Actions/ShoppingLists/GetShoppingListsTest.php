<?php

namespace ClickDs\WhiskApi\Tests\Actions\ShoppingLists;

use ClickDs\WhiskApi\Tests\BaseTestCase;
use ClickDs\WhiskApi\Tests\Support\MockResponses;
use ClickDs\WhiskApi\WhiskApi;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;

/**
 * @group ShoppingLists
 */
class GetShoppingListsTest extends BaseTestCase
{
    use MockResponses;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_guzzle_makes_correct_request(): void
    {
        $uri = '/list/v2';
        $mock = Mockery::mock(Client::class);
        $mock->shouldReceive('request')->once()
            ->with('GET', $uri)
            ->andReturn(new Response(200, [], $this->responseBody()));
        $client = new WhiskApi($mock);

        $response = $client->getShoppingLists();

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('items', $response);
    }

    private function responseBody(): string
    {
        return $this->getSupportJson('shopping-lists.json');
    }
}
