<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

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
        }
        $res = \Guzzle::get("https://spoonacular-recipe-food-nutrition-v1.p.mashape.com/recipes/findByIngredients?fillIngredients=false&ingredients=apples%2Cflour%2Csugar&limitLicense=false&number=5&ranking=1",
            array(
                "X-Mashape-Key" => "IzKzl4eWkZmshal9SRdzpJOdOazcp1LbmUNjsn8Ah1NKjqIFAL",
                "Accept" => "application/json"
            )
        );
        echo $res->getStatusCode();
        echo $res->getHeader('content-type');
        echo $res->getBody();
    }
}
