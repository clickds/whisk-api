Whisk Api is a php library for interacting with the [whisk](https://whisk.com) api.

## Installation

Currently install directly via git

## Usage

```php
use ClickDs\WhiskApi\WhiskApi;
$config = [
  'api_token' => 'your-api-token',
  'token_type' => 'user_access',
];

$apiClient = WhiskApi::create($config);

$apiClient->getFeed();
$apiClient->getRecipe('9773cb7eca5d11e7ae7e42010a9a0035');
```

Passing a token type of user_access sets the authorization header to be a bearer token, anything else and it'll use the whisk server token configuration.

The create method is just a helper. If you'd like you can inject a guzzle client directly into the constuctor instead.

```php
use GuzzleHttp\Client;
use ClickDs\WhiskApi\WhiskApi;

$guzzleClient = new Client($args);
$apiClient = new WhiskApi($guzzleClient);
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](./LICENSE.md)

## Testing against the sandbox environment.

The default test invocation will ignore the tests against the sandbox environment. They are in the sandbox group and can be run with `vendor/bin/phpunit --group=sandbox`

### Whisk API Routes Covered

[API Spec](https://api.whisk.com/spec/)

| **Status** |           **Name**            |                            **Url**                            |                                     **Dev Docs**                                      |
| :--------: | :---------------------------: | :-----------------------------------------------------------: | :-----------------------------------------------------------------------------------: |
|   - [x]    |          Get Recipe           |                https://graph.whisk.com/v1/:id                 |                https://docs.whisk.com/api/recipes/get-recipe-nutrition                |
|   - [ ]    |     Get Recipe Categories     |         https://graph.whisk.com/v1/recipes/categories         |                 https://docs.whisk.com/api/recipes/recipe-categories                  |
|   - [x]    |          Recipe Feed          |                https://graph.whisk.com/v1/feed                |                https://docs.whisk.com/api/recipe-discovery/recipe-feed                |
|   - [x]    |         Recipe Search         |         https://graph.whisk.com/v1/search?type=recipe         |               https://docs.whisk.com/api/recipe-discovery/recipe-search               |
|   - [ ]    |      Get Similar Recipes      | https://graph.whisk.com/v1/feed?type=related&itemId=:recipeId |            https://docs.whisk.com/api/recipe-discovery/get-similar-recipes            |
|   - [ ]    |      Get Shopping Lists       |               https://graph.whisk.com/v1/lists                |             https://docs.whisk.com/api/shopping-lists/get-shopping-lists              |
|   - [ ]    |    Create A Shopping List     |               https://graph.whisk.com/v1/lists                |           https://docs.whisk.com/api/shopping-lists/create-a-shopping-list            |
|   - [ ]    | Add Items To A Shopping List  |             https://graph.whisk.com/v1/:id/items              |        https://docs.whisk.com/api/shopping-lists/add-items-to-a-shopping-list         |
|   - [ ]    |         List analysis         |           https://graph.whisk.com/v1/lists/analyze            |                https://docs.whisk.com/api/shopping-lists/list-analysis                |
|   - [ ]    |     Meal Plan Management      |   https://graph.whisk.com/mealplan/v2/:meal\_plan\_id/meal    |              https://docs.whisk.com/api/meal-plans/meal-plan-management               |
|   - [ ]    |         Delete Meals          |              https://graph.whisk.com/mealplan/v2              |                  https://docs.whisk.com/api/meal-plans/delete-meals                   |
|   - [ ]    |        Auto Generator         |         https://graph.whisk.com/mealplan/v2/generate          |                 https://docs.whisk.com/api/meal-plans/auto-generator                  |
|   - [ ]    |     Get Available Stores      |             https://graph.whisk.com/v1/retailers              |               https://docs.whisk.com/api/retailers/get-available-stores               |
|   - [ ]    |      Search Store Items       |       https://graph.whisk.com/v1/search?type=storeItem        |                https://docs.whisk.com/api/retailers/search-store-items                |
|   - [ ]    |         Create A Cart         |               https://graph.whisk.com/v1/carts                |                    https://docs.whisk.com/api/carts/create-a-cart                     |
|   - [ ]    |       Update Cart Item        |  https://graph.whisk.com/v1/carts/:cart\_id/items/:item\_id   |                   https://docs.whisk.com/api/carts/update-cart-item                   |
|   - [ ]    |     Split Combined Items      |  https://graph.whisk.com/v1/:cart\_id/items/:item\_id/split   |                 https://docs.whisk.com/api/carts/split-combined-items                 |
|   - [ ]    |       Add Items To Cart       |             https://graph.whisk.com/v1/:id/items              |                  https://docs.whisk.com/api/carts/add-items-to-cart                   |
|   - [ ]    |      Add Recipes To Cart      |            https://graph.whisk.com/v1/:id/recipes             |                 https://docs.whisk.com/api/carts/add-recipes-to-cart                  |
|   - [ ]    |     Get Cart Item Options     | https://graph.whisk.com/v1/:cart\_id/items/:item\_id/options  |                https://docs.whisk.com/api/carts/get-cart-item-options                 |
|   - [ ]    |    Swap Cart Item Product     |   https://graph.whisk.com/v1/:cart\_id/items/:item\_id/swap   |                https://docs.whisk.com/api/carts/swap-cart-item-product                |
|   - [ ]    |         Delete A Cart         |             https://graph.whisk.com/v1/:cart\_id              |             https://docs.whisk.com/api/carts/delete-a-cart-or-a-cart-item             |
|   - [ ]    |      Delete A Cart Item       |     https://graph.whisk.com/v1/:cart\_id/items/:item\_id      |             https://docs.whisk.com/api/carts/delete-a-cart-or-a-cart-item             |
|   - [ ]    |           Checkout            |           https://graph.whisk.com/v1/carts/checkout           |                       https://docs.whisk.com/api/carts/checkout                       |
|   - [ ]    |          Get A User           |                 https://graph.whisk.com/v1/me                 |                   https://docs.whisk.com/api/user-model/get-a-user                    |
|   - [ ]    |         Update A User         |                 https://graph.whisk.com/v1/me                 |                  https://docs.whisk.com/api/user-model/update-a-user                  |
|   - [ ]    |  Add User Recipe (Favourite)  |              https://graph.whisk.com/v1/recipes               |        https://docs.whisk.com/api/user-recipes-and-collections/add-user-recipe        |
|   - [ ]    |        Create A Recipe        |              https://graph.whisk.com/v1/recipes               |        https://docs.whisk.com/api/user-recipes-and-collections/create-a-recipe        |
|   - [ ]    |    Update External Recipe     |             https://graph.whisk.com/v1/:recipeId              |         https://docs.whisk.com/api/user-recipes-and-collections/updaterecipe          |
|   - [ ]    |     Get All User Recipes      |              https://graph.whisk.com/v1/recipes               |     https://docs.whisk.com/api/user-recipes-and-collections/get-all-user-recipes      |
|   - [ ]    |      Update User Recipe       |            https://graph.whisk.com/v1/:recipe\_id             |      https://docs.whisk.com/api/user-recipes-and-collections/update-user-recipe       |
|   - [ ]    | Remove Recipe From Favourites |            https://graph.whisk.com/v1/:recipe\_id             | https://docs.whisk.com/api/user-recipes-and-collections/remove-recipe-from-favorites  |
|   - [x]    |       Create Collection       |            https://graph.whisk.com/v1/collections             |       https://docs.whisk.com/api/user-recipes-and-collections/create-collection       |
|   - [ ]    |   Get All User Collections    |            https://graph.whisk.com/v1/collections             |   https://docs.whisk.com/api/user-recipes-and-collections/get-all-user-collections    |
|   - [ ]    |        Get Collection         |          https://graph.whisk.com/v1/:collection\_id           |        https://docs.whisk.com/api/user-recipes-and-collections/get-collection         |
|   - [ ]    |  Get Recipes From Collection  |      https://graph.whisk.com/v1/:collection\_id/recipes       | https://docs.whisk.com/api/user-recipes-and-collections/get-recipes-from-a-collection |
|   - [x]    |       Remove Collection       |          https://graph.whisk.com/v1/:collection\_id           |       https://docs.whisk.com/api/user-recipes-and-collections/remove-collection       |
