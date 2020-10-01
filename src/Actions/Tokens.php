<?php

namespace ClickDs\WhiskApi\Actions;

use GuzzleHttp\HandlerStack;

trait Tokens
{
    /**
     * Refresh a token.
     *
     * $parameters should consist of
     *
     * @param array $parameters
     *                          $parameters = [
     *                          'client_id' => string,
     *                          'client_secret' => string,
     *                          'grant_type' => string,
     *                          'refresh_token' => string,
     *                          ];
     *
     * @return mixed
     */
    public function refreshToken(array $parameters)
    {
        $response = $this->getHttpClient()->request('POST', 'https://login.whisk.com/oauth/v2/token', [
            'form_params' => $parameters,
            // We'll use the default handler so we don't rerun our middleware
            'handler' => HandlerStack::create(),
        ]);

        return json_decode((string) $response->getBody(), true);
    }
}
