<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Unirest;


class RecipesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function recipes()
    {
        return view('recipes')->with("recipes", $this->getReceipes());
    }

    private function getReceipes() {
        $available_products = Product::where("state","ONSTOCK")->get();
        $ingredients = "";
        for ($i = 0; $i < count($available_products); $i++){
            $ingredients .= $available_products[$i]->name;
            if ($i < count($available_products) - 1){
                $ingredients .= ",";
            }
        }/*
        // These code snippets use an open-source library. http://unirest.io/php
        $response = Unirest\Request::get("https://spoonacular-recipe-food-nutrition-v1.p.mashape.com/recipes/findByIngredients?fillIngredients=true&ingredients=".$ingredients."&limitLicense=false&number=5&ranking=1",
            array(
                "X-Mashape-Key" => "IzKzl4eWkZmshal9SRdzpJOdOazcp1LbmUNjsn8Ah1NKjqIFAL",
                "Accept" => "application/json"
            )
        );
        $recipes = [];
        foreach ($response->body as $recipe) {
            $mRecipe = array("title" => $recipe->title, "usedIngredients" => $recipe->usedIngredients, "missedIngredients" => $recipe->missedIngredients, "image" => $recipe->image, "missedIngredientCount" => $recipe->missedIngredientCount, "id" => $recipe->id);
            // These code snippets use an open-source library. http://unirest.io/php
            $mResponse = Unirest\Request::get("https://spoonacular-recipe-food-nutrition-v1.p.mashape.com/recipes/".$recipe->id."/analyzedInstructions?stepBreakdown=false",
                array(
                    "X-Mashape-Key" => "IzKzl4eWkZmshal9SRdzpJOdOazcp1LbmUNjsn8Ah1NKjqIFAL",
                    "Accept" => "application/json"
                )
            );
            $mResponseBody = $mResponse->body;
            $mRecipe["steps"] = $mResponseBody[0]->steps;
            array_push($recipes,$mRecipe);
        }*/
        $recipes = [array("title" => "title", "usedIngredients" => json_decode("[{\"name\":\"test\"}]"), "missedIngredients" => json_decode("[{\"name\":\"test\"}]"), "image" => "/img/ts.jpg", "missedIngredientCount" => 0, "id" => 1, "steps" => json_decode("[{\"step\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum\"},{\"step\":\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum\"}]"))];
        return $recipes;
    }
}
