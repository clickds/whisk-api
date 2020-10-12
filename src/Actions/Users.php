<?php

namespace ClickDs\WhiskApi\Actions;

trait Users
{
    /**
     * Get the current user (requires user authentication token on Guzzle client).
     *
     * @return mixed
     */
    public function getUser()
    {
        $uri = '/user/v2/me';

        return $this->get($uri);
    }

    /**
     * Update user settings.
     *
     * @param array $parameters
     *
     * @return mixed
     */
    public function updateUserSettings(array $parameters)
    {
        $uri = '/user/v2/settings';

        return $this->patch($uri, $parameters);
    }
}
