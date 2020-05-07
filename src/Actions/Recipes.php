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
        if (filter_var($id, FILTER_VALIDATE_URL)) {
            $uri = '?id=' . $id;
        } else {
            $uri = $id;
        }

        return $this->get($uri);
    }

    public function searchRecipes(array $args = [])
    {
        $uri = 'search';
        $queryParameters = array_merge(['type' => 'recipe'], $args);

        return $this->get($uri, $queryParameters);
    }
}
