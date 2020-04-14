<?php

namespace ClickDs\WhiskApi;

trait MakesHttpRequests
{
    /**
     * @return mixed
     */
    public function get(string $uri)
    {
        return $this->request('GET', $uri);
    }

    /**
     * @return mixed
     */
    private function request(string $verb, string $uri, array $payload = [])
    {
        $requestPayload = empty($payload) ? [] : ['form_params' => $payload];
        $response = $this->getHttpClient()->request($verb, $uri, $requestPayload);
        $responseBody = (string) $response->getBody();

        return json_decode($responseBody, true);
    }
}
