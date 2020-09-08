<?php

namespace ClickDs\WhiskApi\Tests\Actions\Recipes;

use ClickDs\WhiskApi\Tests\BaseTestCase;
use ClickDs\WhiskApi\Tests\Support\MockResponses;
use ClickDs\WhiskApi\WhiskApi;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Arr;
use Mockery;

/**
 * @group Recipe
 */
class RemoveRecipeFromCollectionsTest extends BaseTestCase
{
    use MockResponses;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_guzzle_makes_correct_request(): void
    {
        $uri = '/recipe/v2/whisk123';
        $mock = Mockery::mock(Client::class);
        $parameters = [
            'collection_ids' => ['collection1', 'collection2'],
        ];
        $mock->shouldReceive('request')->once()
            ->with('DELETE', $uri, ['json' => $parameters])
            ->andReturn(new Response(200, [], $this->responseBody()));
        $client = new WhiskApi($mock);

        $response = $client->removeRecipeFromCollections('whisk123', ['collection1', 'collection2']);

        $this->assertEmpty($response);
    }

    private function responseBody(): string
    {
        return $this->getSupportJson('remove-recipe-from-collections.json');
    }
}
