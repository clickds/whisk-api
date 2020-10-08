<?php

namespace ClickDs\WhiskApi\Tests\Actions\Feed;

use ClickDs\WhiskApi\Tests\BaseTestCase;
use ClickDs\WhiskApi\Tests\Support\MockResponses;
use ClickDs\WhiskApi\Tests\Support\SandboxClient;
use ClickDs\WhiskApi\WhiskApi;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;

/**
 * @group Feed
 */
class GetFeedTest extends BaseTestCase
{
    use SandboxClient;
    use MockResponses;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * @group sandbox
     */
    public function test_get_feed_from_whisk(): void
    {
        $apiKey = getenv('SERVER_API_KEY');
        $httpClient = $this->createServerTokenSandboxClient($apiKey);
        $client = new WhiskApi($httpClient);

        $response = $client->getFeed();

        $this->assertNotEmpty($response);
    }

    public function test_it_returns_the_content(): void
    {
        $responses = [
            new Response(200, [], $this->responseBody()),
        ];
        $client = $this->createApiClientWithMockedResponses($responses);
        $id = '301d1456411e4082af0e37d12ef5ec49';

        $response = $client->getFeed(['id' => $id]);

        $this->assertEquals($id, $response['id']);
    }

    public function test_guzzle_hits_the_correct_url_when_passed_id(): void
    {
        $id = '301d1456411e4082af0e37d12ef5ec49';
        $uri = '/feed/v2/get';
        $mock = Mockery::mock(Client::class);
        $queryParameters = ['id' => $id];
        $mock->shouldReceive('request')->once()
            ->with('GET', $uri, ['query' => $queryParameters])
            ->andReturn(new Response());
        $client = new WhiskApi($mock);

        $response = $client->getFeed($queryParameters);

        $this->assertEmpty($response);
    }

    private function responseBody(): string
    {
        return $this->getSupportJson('get-feed.json');
    }
}
