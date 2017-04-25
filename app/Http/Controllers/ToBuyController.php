<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\DB;

class ToBuyController extends Controller
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

    public function index()
    {
        return view('shopping_list')->with('products', $this->getToBuyProducts());
    }


    private function getToBuyProducts()
    {
        //return Product::where("state", "TOBUY")->get();
        $products = Product::where("state", "=", "TOBUY")->get();
        $tobuyProducts = [];
        foreach ($products as $product) {
            $stock_product = [];
            $stock_product["id"] = $product->id;
            $stock_product["name"] = $product->name;
            $product_lots = $product->lot;
            $quantity = 0;
            foreach ($product_lots as $lot){
                $quantity += $lot->product_item->where("state","IN")->sum("actual_weight");
            }
            $stock_product["quantity"] = $quantity;
            array_push($tobuyProducts,$stock_product);
        }
        return $tobuyProducts;
    }
}
