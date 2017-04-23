<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function stock()
    {
        return view('stock')->with("stocks", $this->getStock());
    }

    private function getStock() {
        $products = Product::where("state", "!=", "DISABLE")->get();
        $stock = [];
        foreach ($products as $product) {
            $stock_product = [];
            $stock_product["id"] = $product->id;
            $stock_product["name"] = $product->name;
            $stock_product["state"] = $product->state;
            $product_lots = $product->lot;
            $quantity = 0;
            foreach ($product_lots as $lot){
                $quantity += $items_available = $lot->product_item->where("state","IN")->sum("actual_weight");
            }
            $stock_product["quantity"] = $quantity;
            array_push($stock,$stock_product);
        }
        return $stock;
    }
}
