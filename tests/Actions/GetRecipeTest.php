<?php

namespace ClickDs\WhiskApi\Tests\Actions;

use ClickDs\WhiskApi\Tests\Support\MockResponses;
use ClickDs\WhiskApi\WhiskApi;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use PHPUnit\Framework\TestCase;

class GetRecipeTest extends TestCase
{
    use MockResponses;

    protected function tearDown(): void
    {
        Mockery::close();
    }


    public function test_it_returns_the_content(): void
    {
        $responses = [
            new Response(200, [], $this->responseBody()),
        ];
        $client = $this->createClientWithMockedResponses($responses);
        $id = '9773cb7eca5d11e7ae7e42010a9a0035';

        $response = $client->getRecipe($id);

        $this->assertEquals($id, $response['id']);
    }

    public function test_guzzle_hits_the_correct_url_when_passed_id(): void
    {
        $id = '9773cb7eca5d11e7ae7e42010a9a0035';
        $uri = '/v1/' . $id;
        $mock = Mockery::mock(Client::class);
        $mock->shouldReceive('request')->once()->with('GET', $uri, [])->andReturn(new Response());
        $client = new WhiskApi($mock);

        $response = $client->getRecipe($id);

        $this->assertEmpty($response);
    }

    public function test_guzzle_hits_the_correct_url_when_passed_url_as_id(): void
    {
        $id = 'https://www.whisk.com/api/9773cb7eca5d11e7ae7e42010a9a0035';
        $uri = '/v1/?id=' . $id;
        $mock = Mockery::mock(Client::class);
        $mock->shouldReceive('request')->once()->with('GET', $uri, [])->andReturn(new Response());
        $client = new WhiskApi($mock);

        $response = $client->getRecipe($id);

        $this->assertEmpty($response);
    }

    private function responseBody(array $extraFields = []): string
    {
        $data = $this->baseData();

        if (array_key_exists('instructions', $extraFields)) {
            $data['instructions'] = $this->instructionFields();
        }

        if (array_key_exists('normalizedIngredients', $extraFields)) {
            $data['normalizedIngredients'] = $this->normalizedIngredientFields();
        }

        if (array_key_exists('nutrition', $extraFields)) {
            $data["nutrition"] = $this->nutritionFields();
        }

        $encodedData = json_encode($data);
        if ($encodedData) {
            return $encodedData;
        }
        throw new Exception('Could not encode JSON');
    }

    private function baseData(): array
    {
        return [
            "id" => "9773cb7eca5d11e7ae7e42010a9a0035",
            "name" => "Omelette pancakes with tomato & pepper sauce",
            "description" => "Healthy, low-calorie and gluten-free - these herby egg 'pancakes' will become your go-to favourite for a quick midweek meal",
            "ingredients" => [
                [
                    "text" => "4 large eggs"
                ],
                [
                    "text" => "handful basil leaves"
                ],
            ],
            "images" => [
                [
                    "url" => "https://www.bbcgoodfood.com/sites/default/files/styles/recipe/public/recipe_images/omelette-pancakes-with-tomato-pepper-sauce.jpg",
                    "responsive" => [
                        "url" => "https://lh3.googleusercontent.com/Fw3mfAzXomFv3iU-PO8ASPuvDN0AA6U8DlTXn6GkwUbJrq6IcGC8ZCzdnzZyZbqUsoxSR4fv3LVk3HuM8xURFq7qfQ8",
                        "width" => 500,
                        "height" => 454
                    ]
                ]
            ],
            "source" => [
                "name" => "bbcgoodfood.com",
                "displayName" => "BBC Good Food",
                "sourceRecipeUrl" => "https://www.bbcgoodfood.com/recipes/omelette-pancakes-tomato-pepper-sauce",
                "license" => "Fairuse",
                "image" => [
                    "url" => "https://res.cloudinary.com/whisk/image/upload/v1401879186/content/publisher_logos/foodnetwork-logo.png",
                    "responsive" => [
                        "url" => "https://res.cloudinary.com/whisk/image/upload/v1401879186/content/publisher_logos/foodnetwork-logo.png",
                        "width" => 200,
                        "height" => 200
                    ]
                ]
            ],
            "author" => [
                "name" => "Author name",
                "image" => [
                    "url" => "https://whisk-res.cloudinary.com/image/upload/v1523894700/custom_upload/ba4d7363cd46c736675d2cc08754f5bc.png",
                    "responsive" => [
                        "url" => "https://whisk-res.cloudinary.com/image/upload/v1523894700/custom_upload/ba4d7363cd46c736675d2cc08754f5bc.png",
                        "width" => 800,
                        "height" => 800
                    ]
                ]
            ],
            "numberOfServings" => 2,
            "durations" => [
                "cookTime" => 20,
                "prepTime" => 10,
                "totalTime" => 30
            ],
            "labels" => [
                "mealType" => [
                    [
                        "name" => "lunch",
                        "displayName" => "Lunch"
                    ],
                    [
                        "name" => "main-course",
                        "displayName" => "Main Course"
                    ],
                    [
                        "name" => "dinner",
                        "displayName" => "Dinner"
                    ]
                ],
                "cuisine" => [
                    [
                        "name" => "french",
                        "displayName" => "French"
                    ]
                ],
                "category" => [
                    [
                        "name" => "dinner",
                        "displayName" => "Dinner"
                    ],
                    [
                        "name" => "healthy-recipes",
                        "displayName" => "Healthy Recipes"
                    ],
                    [
                        "name" => "main-dishes",
                        "displayName" => "Main Dishes"
                    ]
                ]
            ],
            "constraints" => [
                "violates" => [
                    "diets" => [
                        "lacto-vegetarian",
                        "vegetarian",
                        "vegan"
                    ],
                    "avoidances" => [
                        "egg",
                        "wheat"
                    ]
                ]
            ]
        ];
    }

    private function instructionFields(): array
    {
        return [
            "steps" => [
                [
                    "text" => "First make the sauce. Heat the oil in a large frying pan, and fry the pepper and garlic for 5 mins to soften them. Spoon in the cider vinegar and allow to sizzle away. Tip in the tomatoes, then measure in a third of a can of water. Cover and leave to simmer for 10-15 mins until the peppers are tender and the sauce is thick.",
                    "images" => []
                ],
                [
                    "text" => "Meanwhile, make the pancakes. Beat 1 egg with 1 tsp water and seasoning, then heat a small non-stick frying pan with a tiny amount of oil. Add the egg mixture and cook for 1-2 mins until set into a thin pancake. Lift onto a plate, cover with foil and repeat with the other eggs. Roll up onto warm plates, spoon over the sauce and scatter with the basil. Serve with bread or a salad on the side.",
                    "images" => []
                ]
            ]
        ];
    }

    private function normalizedIngredientFields(): array
    {
        return [
            [
                "text" => "4 eggs",
                "analysis" => [
                    "product" => "eggs",
                    "canonicalName" => "EGG",
                    "quantity" => 4,
                    "category" => "DAIRY AND EGGS"
                ],
                "sourceText" => "4 large eggs"
            ],
            [
                "text" => "handful basil leaves",
                "analysis" => [
                    "product" => "basil leaves",
                    "canonicalName" => "BASIL LEAF",
                    "unit" => "handful",
                    "category" => "FRUITS AND VEGETABLES"
                ],
                "sourceText" => "handful basil leaves"
            ],
        ];
    }

    private function nutritionFields(): array
    {
        return [
            "status" => "Available",
            "total" => [
                [
                    "label" => "Protein",
                    "code" => "PROCNT",
                    "value" => 27.209,
                    "unit" => "G"
                ],
                [
                    "label" => "Energy",
                    "code" => "ENERC_KCAL",
                    "value" => 486.629,
                    "unit" => "Kcal"
                ],
                [
                    "label" => "Total Fat",
                    "code" => "FAT",
                    "value" => 26.127000000000006,
                    "unit" => "G"
                ],
                [
                    "label" => "Carbohydrate Total",
                    "code" => "CHOCDF",
                    "value" => 32.392,
                    "unit" => "G"
                ],
            ],
            "labels" => [
                [
                    "name" => "low-sugars",
                    "displayName" => "Low Sugars"
                ],
                [
                    "name" => "high-protein",
                    "displayName" => "High Protein"
                ],
            ],
            "healthScore" => [
                "value" => 5.268321569830008,
                "nutrientsInfluence" => [
                    [
                        "code" => "FAT_UNSAT",
                        "influence" => 0.7392201843132631,
                        "comment" => "Medium positive impact"
                    ],
                    [
                        "code" => "SUGAR",
                        "influence" => -0.1766434534398728,
                        "comment" => "Low negative impact"
                    ],
                ]
            ]
        ];
    }
}
