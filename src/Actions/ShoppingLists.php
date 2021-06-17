<?php

namespace ClickDs\WhiskApi\Actions;

trait ShoppingLists
{
    /**
     * Get Shopping Lists for the current user.
     *
     * @return mixed
     */
    public function getShoppingLists()
    {
        $uri = '/list/v2';

        return $this->get($uri);
    }

    /**
     * Get a specific shopping list.
     *
     * @return mixed
     */
    public function getShoppingList($id)
    {
        $uri = '/list/v2/'.$id;

        return $this->get($uri);
    }

    /**
     * Create a shopping list.
     *
     * @return mixed
     */
    public function createShoppingList(array $params)
    {
        $uri = '/list/v2';

        return $this->post($uri, $params);
    }

    /**
     * Add Items to Shopping List.
     *
     * @return mixed
     */
    public function addItemsToShoppingList(string $id, array $params)
    {
        $uri = '/list/v2/'.$id.'/item';

        return $this->put($uri, $params);
    }

    /**
     * Remove Item from a Shopping List.
     *
     * @return mixed
     */
    public function removeItemFromShoppingList(string $listId, string $itemId)
    {
        $uri = '/list/v2/'.$listId.'/item/'.$itemId;

        return $this->delete($uri);
    }

    /**
     * Clear Items from Shopping List.
     *
     * @return mixed
     */
    public function clearItemsFromShoppingList(string $listId)
    {
        $uri = '/list/v2/'.$listId.'/item';
        $params = [
            'only_checked' => false,
        ];

        return $this->delete($uri, $params);
    }
}
