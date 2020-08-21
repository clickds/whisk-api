<?php

namespace ClickDs\WhiskApi\Actions;

trait Users
{
    /**
     * Get the current user (requires user authentication token on Guzzle client)
     *
     * @param array $parameters
     *
     * @return mixed
     */
    public function getUser()
    {
        $uri = '/user/v2/me';

        return $this->get($uri);
    }
}
