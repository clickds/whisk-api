<?php

namespace ClickDs\WhiskApi\Tests\Actions\ShoppingBasket;

use ClickDs\WhiskApi\Tests\BaseTestCase;
use ClickDs\WhiskApi\Tests\Support\MockResponses;
use ClickDs\WhiskApi\WhiskApi;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;

/**
 * @group ShoppingBasket
 */
class ConvertToShoppingBasketTest extends BaseTestCase
{
    use MockResponses;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_guzzle_makes_correct_request(): void
    {
        $uri = 'https://graph.whisk.com/v1/lists/transfers';
        $params = [
            'items' => [
                [
                    'name'     => 'milk',
                    'quantity' => 250,
                    'unit'     => 'ml',
                ],
            ],
        ];
        $mock = Mockery::mock(Client::class);
        $mock->shouldReceive('request')->once()
            ->with('POST', $uri, ['json' => $params])
            ->andReturn(new Response(200, [], $this->responseBody()));
        $client = new WhiskApi($mock);

        $response = $client->convertToShoppingBasket($params);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('landingUrl', $response);
    }

    private function responseBody(): string
    {
        return json_encode([
            'landingUrl' => 'https://graph.whisk.com/v1/lists/transfers/9e107d15377f484eb7c343f93028b936/landing',
        ]);
    }
}
