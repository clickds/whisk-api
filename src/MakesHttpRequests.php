<?php

namespace ClickDs\WhiskApi;

use Exception;

trait MakesHttpRequests
{
    private function getHttpClient()
    {
        throw new Exception('You must define a private getHttpClient method');
    }

    /**
     * @param string $uri
     * @param array  $queryParameters
     *
     * @return mixed
     */
    public function get(string $uri, array $queryParameters = [])
    {
        $payload = [];
        if (!empty($queryParameters)) {
            $payload['query'] = $queryParameters;
        }

        return $this->request('GET', $uri, $payload);
    }

    /**
     * @param string $uri
     * @param array  $formParameters
     *
     * @return mixed
     */
    public function post(string $uri, array $formParameters = [])
    {
        $payload = [];
        if (!empty($formParameters)) {
            $payload['form_params'] = $formParameters;
        }

        return $this->request('POST', $uri, $payload);
    }

    /**
     * @param string $uri
     *
     * @return mixed
     */
    public function delete(string $uri, array $parameters = [])
    {
        $payload = [];
        if (!empty($parameters)) {
            $payload['json'] = $parameters;
        }

        return $this->request('DELETE', $uri, $payload);
    }

    /**
     * @param string     $verb
     * @param string     $uri
     * @param array|null $payload
     *
     * @return mixed
     */
    private function request(string $verb, string $uri, array $payload = [])
    {
        if (empty($payload)) {
            $response = $this->getHttpClient()->request($verb, $uri);
        } else {
            $response = $this->getHttpClient()->request($verb, $uri, $payload);
        }
        $responseBody = (string) $response->getBody();

        return json_decode($responseBody, true);
    }
}
