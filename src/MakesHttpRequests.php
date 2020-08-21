<?php

namespace ClickDs\WhiskApi;

trait MakesHttpRequests
{
    /**
     * @param string $uriSegment
     * @param array  $queryParameters
     *
     * @return mixed
     */
    public function get(string $uriSegment, array $queryParameters = [])
    {
        $uri = $this->buildUri($uriSegment);
        $payload = [];
        if (!empty($queryParameters)) {
            $payload['query'] = $queryParameters;
        }

        return $this->request('GET', $uri, $payload);
    }

    /**
     * @param string $uriSegment
     * @param array  $formParameters
     *
     * @return mixed
     */
    public function post(string $uriSegment, array $formParameters = [])
    {
        $uri = $this->buildUri($uriSegment);
        $payload = [];
        if (!empty($formParameters)) {
            $payload['form_params'] = $formParameters;
        }

        return $this->request('POST', $uri, $payload);
    }

    /**
     * @param string $uriSegment
     *
     * @return mixed
     */
    public function delete(string $uriSegment)
    {
        $uri = $this->buildUri($uriSegment);

        return $this->request('DELETE', $uri);
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

    private function buildUri(string $uriSegment): string
    {
        return '/'.$this->getVersion().'/'.$uriSegment;
    }
}
