<?php

namespace ClickDs\WhiskApi\Actions;

trait Feed
{
    /**
     * @param array $queryParameters
     *
     * @return mixed
     */
    public function getFeed(array $queryParameters = [])
    {
        $uri = 'feed';

        return $this->get($uri, $queryParameters);
    }
}
