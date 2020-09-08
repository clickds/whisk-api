<?php

namespace ClickDs\WhiskApi\Tests\Actions\Recipes;

use ClickDs\WhiskApi\Tests\BaseTestCase;
use ClickDs\WhiskApi\Tests\Support\SandboxClient;
use ClickDs\WhiskApi\WhiskApi;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;

/**
 * @group SearchRecipes
 * @group Recipes
 */
class SearchRecipesTest extends BaseTestCase
{
    use SandboxClient;

    /**
     * @group sandbox
     */
    public function test_search_recipes_from_whisk(): void
    {
        $apiKey = getenv('SERVER_API_KEY');
        $httpClient = $this->createServerTokenSandboxClient($apiKey);
        $client = new WhiskApi($httpClient);

        $response = $client->searchRecipes([
            'query' => 'sandwich',
        ]);

        $this->assertNotEmpty($response);
    }

    public function test_search_successful(): void
    {
        $uri = '/recipe/v2/search';
        $mock = Mockery::mock(Client::class);
        $mock->shouldReceive('request')->once()->with('POST', $uri, [
            'form_params' => [
                'query' => 'abc'
            ]
        ])
            ->andReturn(new Response(200, [], $this->responseBody()));
        $client = new WhiskApi($mock);

        $response = $client->searchRecipes([
            'query' => 'abc',
        ]);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('recipes', $response);
    }

    private function responseBody(): string
    {
        return $this->getSupportJson('search-recipes.json');
    }
}
