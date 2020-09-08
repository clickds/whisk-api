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
        $uri = '/recipe/v2/' . $id;

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
