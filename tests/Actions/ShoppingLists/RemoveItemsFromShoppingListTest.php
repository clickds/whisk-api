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
class RemoveItemsFromShoppingListTest extends BaseTestCase
{
    use MockResponses;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_guzzle_makes_correct_request(): void
    {
        $listId = 'shopping-list';
        $uri = '/list/v2/'.$listId.'/items';
        $itemId = 'abc';
        $params = [
            'list_id'  => $listId,
            'item_ids' => [
                $itemId,
            ],
        ];
        $mock = Mockery::mock(Client::class);
        $mock->shouldReceive('request')->once()
            ->with('DELETE', $uri, ['json' => $params])
            ->andReturn(new Response(200, [], $this->responseBody()));
        $client = new WhiskApi($mock);

        $response = $client->removeItemsFromShoppingList($listId, [$itemId]);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('list', $response);
        $this->assertArrayHasKey('content', $response);
    }

    private function responseBody(): string
    {
        return $this->getSupportJson('remove-item-from-shopping-list.json');
    }
}
