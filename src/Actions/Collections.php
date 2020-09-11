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
        $uri = '/recipe/v2/collection';

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
        $uri = '/collection/v2/' . $id;

        return $this->delete($uri);
    }

    /**
     * Get recipes in a collection
     *
     * @param int|string $id
     *
     * @return mixed
     */
    public function getRecipesInCollection($id)
    {
        $uri = '/collection/v2/' . $id . '/recipe';

        return $this->get($uri);
    }
}
