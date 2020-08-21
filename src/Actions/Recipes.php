<?php

namespace ClickDs\WhiskApi\Actions;

trait Recipes
{
    /**
     * Get a recipe.
     *
     * @param int|string $id
     *
     * @return mixed
     */
    public function getRecipe($id)
    {
        $uri = '/v1/';
        if (filter_var($id, FILTER_VALIDATE_URL)) {
            $uri .= '?id='.$id;
        } else {
            $uri .= $id;
        }

        return $this->get($uri);
    }

    /**
     * Search recipes.
     *
     * @param array $args
     *
     * @return mixed
     */
    public function searchRecipes(array $args = [])
    {
        $uri = '/v1/search';
        $queryParameters = array_merge(['type' => 'recipe'], $args);

        return $this->get($uri, $queryParameters);
    }
}
