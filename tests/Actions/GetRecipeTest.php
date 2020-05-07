<?php

namespace ClickDs\WhiskApi\Tests\Actions;

use ClickDs\WhiskApi\Tests\BaseTestCase;
use ClickDs\WhiskApi\Tests\Support\MockResponses;
use ClickDs\WhiskApi\Tests\Support\SandboxClient;
use ClickDs\WhiskApi\WhiskApi;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;

class GetRecipeTest extends BaseTestCase
{
    use MockResponses;
    use SandboxClient;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * @group sandbox
     */
    public function test_get_recipe_from_whisk_with_id(): void
    {
        $recipeId = 'https://www.deliciousmagazine.co.uk/recipes/salmon-with-crunchy-quick-pickled-fennel-salad&fields=nutrition,instructions';
        $apiKey = getenv('SERVER_API_KEY');
        $httpClient = $this->createServerTokenSandboxClient($apiKey);
        $client = new WhiskApi($httpClient);

        $response = $client->getRecipe($recipeId);

        $this->assertNotEmpty($response);
        $this->assertEquals('101dc8b84c1ddcbc77adb29e9f17b56fe2512d71d5f', $response['id']);
        $this->assertEquals('Salmon with crunchy, quick-pickled fennel salad', $response['name']);
        $this->assertEquals('This fresh and healthy salmon recipe that takes 20 minutes from start to finish.', $response['description']);
    }

    public function test_it_returns_the_content(): void
    {
        $responses = [
            new Response(200, [], $this->responseBody()),
        ];
        $client = $this->createClientWithMockedResponses($responses);
        $id = '9773cb7eca5d11e7ae7e42010a9a0035';

        $response = $client->getRecipe($id);

        $this->assertEquals($id, $response['id']);
    }

    public function test_guzzle_hits_the_correct_url_when_passed_id(): void
    {
        $id = '9773cb7eca5d11e7ae7e42010a9a0035';
        $uri = '/v1/'.$id;
        $mock = Mockery::mock(Client::class);
        $mock->shouldReceive('request')->once()->with('GET', $uri, [])->andReturn(new Response());
        $client = new WhiskApi($mock);

        $response = $client->getRecipe($id);

        $this->assertEmpty($response);
    }

    public function test_guzzle_hits_the_correct_url_when_passed_url_as_id(): void
    {
        $id = 'https://www.whisk.com/api/9773cb7eca5d11e7ae7e42010a9a0035';
        $uri = '/v1/?id='.$id;
        $mock = Mockery::mock(Client::class);
        $mock->shouldReceive('request')->once()->with('GET', $uri, [])->andReturn(new Response());
        $client = new WhiskApi($mock);

        $response = $client->getRecipe($id);

        $this->assertEmpty($response);
    }

    private function responseBody(): string
    {
        return $this->getSupportJson('get-recipe.json');
    }
}
