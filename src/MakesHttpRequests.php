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
     * @param string       $uri
     * @param array|string $queryParameters
     *
     * @return mixed
     */
    public function get(string $uri, $queryParameters = [])
    {
        $payload = [];
        if (!empty($queryParameters)) {
            $payload['query'] = $queryParameters;
        }

        return $this->request('GET', $uri, $payload);
    }

    /**
     * @param string $uri
     * @param array  $parameters
     *
     * @return mixed
     */
    public function post(string $uri, array $parameters = [])
    {
        $payload = [];
        if (!empty($parameters)) {
            $payload['json'] = $parameters;
        }

        return $this->request('POST', $uri, $payload);
    }

    /**
     * @param string $uri
     * @param array  $parameters
     *
     * @return mixed
     */
    public function put(string $uri, array $parameters = [])
    {
        $payload = [];
        if (!empty($parameters)) {
            $payload['json'] = $parameters;
        }

        return $this->request('PUT', $uri, $payload);
    }

    /**
     * @param string $uri
     * @param array  $parameters
     *
     * @return mixed
     */
    public function patch(string $uri, array $parameters = [])
    {
        $payload = [];
        if (!empty($parameters)) {
            $payload['json'] = $parameters;
        }

        return $this->request('PATCH', $uri, $payload);
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
