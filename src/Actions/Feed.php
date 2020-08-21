<?php

namespace ClickDs\WhiskApi\Actions;

trait Feed
{
    /**
     * Get the feed.
     *
     * @param array $queryParameters
     *
     * @return mixed
     */
    public function getFeed(array $queryParameters = [])
    {
        $uri = '/v1/feed';

        return $this->get($uri, $queryParameters);
    }
}
