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
class GetShoppingListTest extends BaseTestCase
{
    use MockResponses;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_guzzle_makes_correct_request(): void
    {
        $id = 'whisk-shopping-list';
        $uri = '/list/v2'.'/'.$id;
        $mock = Mockery::mock(Client::class);
        $mock->shouldReceive('request')->once()
            ->with('GET', $uri)
            ->andReturn(new Response(200, [], $this->responseBody()));
        $client = new WhiskApi($mock);

        $response = $client->getShoppingList($id);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('list', $response);
        $this->assertArrayHasKey('content', $response);
    }

    private function responseBody(): string
    {
        return $this->getSupportJson('shopping-list.json');
    }
}
