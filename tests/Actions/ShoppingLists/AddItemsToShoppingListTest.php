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
class AddItemsToShoppingListTest extends BaseTestCase
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
        $params = [
            'recipes' => [
                [
                    'recipe_id' => '10745889d4a1c0f4b8dbfab66bffa433524',
                ],
            ],
        ];
        $mock = Mockery::mock(Client::class);
        $mock->shouldReceive('request')->once()
            ->with('PUT', $uri, ['json' => $params])
            ->andReturn(new Response(200, [], $this->responseBody()));
        $client = new WhiskApi($mock);

        $response = $client->addItemsToShoppingList($listId, $params);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('list', $response);
        $this->assertArrayHasKey('content', $response);
    }

    private function responseBody(): string
    {
        return $this->getSupportJson('add-items-to-shopping-list.json');
    }
}
