<?php

namespace ClickDs\WhiskApi\Tests\Actions\Collections;

use ClickDs\WhiskApi\Tests\BaseTestCase;
use ClickDs\WhiskApi\Tests\Support\MockResponses;
use ClickDs\WhiskApi\Tests\Support\SandboxClient;
use ClickDs\WhiskApi\WhiskApi;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;

/**
 * @group Users
 */
class UpdateSettingsTest extends BaseTestCase
{
    use MockResponses;
    use SandboxClient;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_guzzle_makes_correct_request(): void
    {
        $uri = '/user/v2/settings';
        $mock = Mockery::mock(Client::class);
        $mock->shouldReceive('request')->once()
            ->with('PATCH', $uri, [
                'json' => [
                    'settings' => [
                        'personal_details' => [
                            'first_name' => 'Joe',
                            'last_name' => 'Bloggs',
                        ]
                    ],
                ],
            ])
            ->andReturn(new Response(200, [], $this->responseBody()));
        $client = new WhiskApi($mock);

        $response = $client->updateUserSettings([
            'settings' => [
                'personal_details' => [
                    'first_name' => 'Joe',
                    'last_name' => 'Bloggs',
                ]
            ],
        ]);

        $this->assertNotEmpty($response);
        $this->assertArrayHasKey('user', $response, 'Could not find user key');
        $this->assertEquals($response['user']['user_settings']['personal_details']['first_name'], 'Joe');
        $this->assertEquals($response['user']['user_settings']['personal_details']['last_name'], 'Bloggs');
    }

    private function responseBody(): string
    {
        return $this->getSupportJson('user-settings.json');
    }
}
