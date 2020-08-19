<?php

namespace ClickDs\WhiskApi;

trait MakesHttpRequests
{
    /**
     * @return mixed
     */
    public function get(string $uri, array $queryParameters = [])
    {
        $uri = '/' . $this->getVersion() . '/' . $uri;
        $payload = [];
        if (!empty($queryParameters)) {
            $payload['query'] = $queryParameters;
        }

        return $this->request('GET', $uri, $payload);
    }

    /**
     * @return mixed
     */
    public function post(string $uri, array $formParameters = [])
    {
        $uri = '/' . $this->getVersion() . '/' . $uri;
        $payload = [];
        if (!empty($formParameters)) {
            $payload['form_params'] = $formParameters;
        }

        return $this->request('POST', $uri, $payload);
    }

    /**
     * @return mixed
     */
    private function request(string $verb, string $uri, array $payload = [])
    {
        $response = $this->getHttpClient()->request($verb, $uri, $payload);
        $responseBody = (string) $response->getBody();

        return json_decode($responseBody, true);
    }
}
