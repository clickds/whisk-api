<?php

namespace ClickDs\WhiskApi;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class TokenManager
{
    use MakesHttpRequests;

    private string $clientId;
    private string $clientSecret;
    private ClientInterface $client;

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @param ClientInterface $client = null;
     */
    public function __construct(string $clientId, string $clientSecret, ClientInterface $client = null)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->httpClient = is_null($client) ? new Client() : $client;
    }

    /**
     * @param string $authorizationCode
     * @param string $redirectUrl
     *
     * @return mixed
     */
    public function fetchAccessToken(string $authorizationCode, string $redirectUrl)
    {
        return $this->post('https://login.whisk.com/oauth/v2/token', [
            'code' => $authorizationCode,
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'grant_type' => 'authorization_code',
            'redirect_url' => $redirectUrl,
        ]);
    }

    /**
     * @param string $refreshToken
     *
     * @return mixed
     */
    public function refreshToken(string $refreshToken)
    {
        return $this->post('https://login.whisk.com/oauth/v2/token', [
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
        ]);
    }

    private function getHttpClient(): ClientInterface
    {
        return $this->httpClient;
    }

    private function getClientId(): string
    {
        return $this->clientId;
    }

    private function getClientSecret(): string
    {
        return $this->clientSecret;
    }
}
