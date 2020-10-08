<?php

namespace ClickDs\WhiskApi\Tests\Actions\Recipes;

use ClickDs\WhiskApi\Tests\BaseTestCase;
use ClickDs\WhiskApi\Tests\Support\MockResponses;
use ClickDs\WhiskApi\WhiskApi;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;

/**
 * @group Recipe
 */
class AddRecipeToCollectionsTest extends BaseTestCase
{
    use MockResponses;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_guzzle_makes_correct_request(): void
    {
        $uri = '/recipe/v2';
        $mock = Mockery::mock(Client::class);
        $parameters = [
            'recipe_id'      => 'whisk123',
            'collection_ids' => ['collection1', 'collection2'],
        ];
        $mock->shouldReceive('request')->once()
            ->with('POST', $uri, ['form_params' => $parameters])
            ->andReturn(new Response(200, [], $this->responseBody()));
        $client = new WhiskApi($mock);

        $response = $client->addRecipeToCollections('whisk123', ['collection1', 'collection2']);

        $this->assertNotEmpty($response);
        $this->assertEquals('whisk123', $response['id']);
        $collectionIds = $response['saved']['collection_ids'];
        $this->assertContains('collection1', $collectionIds);
        $this->assertContains('collection2', $collectionIds);
    }

    private function responseBody(): string
    {
        return $this->getSupportJson('add-recipe-to-collections.json');
    }
}
