<?php

namespace ClickDs\WhiskApi\Tests\Actions;

use ClickDs\WhiskApi\Tests\BaseTestCase;
use ClickDs\WhiskApi\Tests\Support\SandboxClient;
use ClickDs\WhiskApi\WhiskApi;

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
            'q' => 'salad',
        ]);

        $this->assertNotEmpty($response);
    }
}
