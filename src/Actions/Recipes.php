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
        if (filter_var($id, FILTER_VALIDATE_URL) === false) {
            $uri = '/recipe/v2/get?id='.$id;
        } else {
            $uri = '/recipe/v2/get?id='.$id;
        }

        return $this->get($uri, $args);
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
        $uri = '/recipe/v2/'.$recipeId;
        $parameters = [
            'collection_ids' => $collectionIds,
        ];

        return $this->delete($uri, $parameters);
    }
}
