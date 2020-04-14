<?php

namespace ClickDs\WhiskApi\Actions;

trait Recipes
{
    /**
     * @param int|string $id
     *
     * @return mixed
     */
    public function getRecipe($id)
    {
        $uri = '/v1/';
        if (filter_var($id, FILTER_VALIDATE_URL)) {
            $uri .= '?id=' . $id;
        } else {
            $uri .= $id;
        }

        return $this->get($uri);
    }
}
