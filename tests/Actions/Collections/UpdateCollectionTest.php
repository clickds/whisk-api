<?php

namespace ClickDs\WhiskApi\Tests\Actions\Collections;

use ClickDs\WhiskApi\Tests\BaseTestCase;
use ClickDs\WhiskApi\Tests\Support\MockResponses;
use ClickDs\WhiskApi\WhiskApi;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;

/**
 * @group Collections
 */
class UpdateCollectionTest extends BaseTestCase
{
    use MockResponses;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_guzzle_makes_correct_request(): void
    {
        $id = 'whiskabc123';
        $uri = '/recipe/v2/collection/'.$id;
        $mock = Mockery::mock(Client::class);
        $mock->shouldReceive('request')->once()
            ->with('PUT', $uri, ['json' => ['name' => 'New name']])
            ->andReturn(new Response(200, [], $this->responseBody()));
        $client = new WhiskApi($mock);

        $response = $client->updateCollection($id, [
            'name' => 'New name',
        ]);

        $this->assertNotEmpty($response);
        $this->assertEquals('New name', $response['collection']['name']);
    }

    private function responseBody(): string
    {
        return json_encode([
            'collection' => [
                'id'            => '1',
                'name'          => 'New name',
                'recipes_count' => 0,
            ],
        ]);
    }
}
