<?php

namespace ClickDs\WhiskApi\Actions;

trait Collections
{
    /**
     * Create a collection.
     *
     * @param array $parameters
     *
     * @return mixed
     */
    public function createCollection(array $parameters = [])
    {
        $uri = 'collections';

        return $this->post($uri, $parameters);
    }

    /**
     * Delete a collection.
     *
     * @param int|string $id
     *
     * @return mixed
     */
    public function deleteCollection($id)
    {
        return $this->delete($id);
    }
}
