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
class ClearItemsFromShoppingListTest extends BaseTestCase
{
    use MockResponses;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_guzzle_makes_correct_request(): void
    {
        $listId = 'shopping-list';
        $uri = '/list/v2/'.$listId.'/item';
        $mock = Mockery::mock(Client::class);
        $mock->shouldReceive('request')->once()
            ->with('DELETE', $uri, ['json' => ['only_checked' => false]])
            ->andReturn(new Response(200, [], $this->responseBody()));
        $client = new WhiskApi($mock);

        $response = $client->clearItemsFromShoppingList($listId);

        $this->assertEmpty($response);
    }

    private function responseBody(): string
    {
        return '{}';
    }
}
