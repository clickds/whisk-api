<?php

namespace ClickDs\WhiskApi\Actions;

trait Recipes
{
    /**
     * Get a recipe.
     *
     * @param int|string   $id
     * @param array|string $args
     *
     * @return mixed
     */
    public function getRecipe($id, $args = [])
    {
        $uri = '/recipe/v2/get';

        // Guzzle will set array parameters in a query string like fields[]=
        // but Whisk only works with them like fields=1&fields=2
        // This forces the format whisk uses.
        foreach ($args as $key => $value) {
            if (is_array($value)) {
                $separator = '&' . $key . '=';
                $args[$key] = implode($separator, $value);
            }
        }
        $queryString = 'id=' . $id;
        foreach ($args as $key => $value) {
            $queryString .= '&' . $key . '=' . $value;
        }

        return $this->get($uri, $queryString);
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
        $uri = '/recipe/v2/search';

        return $this->post($uri, $args);
    }

    /**
     * Add recipe to collections.
     *
     * @param string $recipeId
     * @param array  $collectionIds
     *
     * @return mixed
     */
    public function addRecipeToCollections(string $recipeId, array $collectionIds)
    {
        $uri = '/recipe/v2';
        $parameters = [
            'recipe_id'      => $recipeId,
            'collection_ids' => $collectionIds,
        ];

        return $this->post($uri, $parameters);
    }

    /**
     * Remove recipe from collections.
     *
     * @param string $recipeId
     * @param array  $collectionIds
     *
     * @return mixed
     */
    public function removeRecipeFromCollections(string $recipeId, array $collectionIds)
    {
        $uri = '/recipe/v2/' . $recipeId;
        $parameters = [
            'collection_ids' => $collectionIds,
        ];

        return $this->delete($uri, $parameters);
    }
}
