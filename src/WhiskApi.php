<?php

namespace ClickDs\WhiskApi;

use ClickDs\WhiskApi\Actions\Collections;
use ClickDs\WhiskApi\Actions\Feed;
use ClickDs\WhiskApi\Actions\Recipes;
use ClickDs\WhiskApi\Actions\ShoppingBasket;
use ClickDs\WhiskApi\Actions\ShoppingLists;
use ClickDs\WhiskApi\Actions\Users;
use GuzzleHttp\Client as HttpClient;

class WhiskApi
{
    use MakesHttpRequests;
    use Collections;
    use Feed;
    use Recipes;
    use ShoppingBasket;
    use ShoppingLists;
    use Users;

    /**
     * @var HttpClient
     */
    private $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    private function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }

    /**
     * @param Configuration $configuration
     */
    public static function createApiClient(Configuration $configuration): WhiskApi
    {
        $client = new HttpClient($configuration->guzzleConfig());

        return new WhiskApi($client);
    }
}
