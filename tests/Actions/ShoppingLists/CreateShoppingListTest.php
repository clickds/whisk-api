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
class CreateShoppingListTest extends BaseTestCase
{
    use MockResponses;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_guzzle_makes_correct_request(): void
    {
        $uri = '/list/v2';
        $params = [
            'name' => 'My Shopping List',
        ];
        $mock = Mockery::mock(Client::class);
        $mock->shouldReceive('request')->once()
            ->with('POST', $uri, ['json' => $params])
            ->andReturn(new Response(200, [], $this->responseBody()));
        $client = new WhiskApi($mock);

        $response = $client->createShoppingList($params);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('name', $response);
        $this->assertEquals($response['name'], 'My Shopping List');
    }

    private function responseBody(): string
    {
        return $this->getSupportJson('create-shopping-list.json');
    }
}
