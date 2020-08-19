<?php

namespace ClickDs\WhiskApi\Actions;

trait Collections
{
    /**
     * @param array $parameters
     *
     * @return mixed
     */
    public function createCollection(array $parameters = [])
    {
        $uri = 'collections';

        return $this->post($uri, $parameters);
    }
}
