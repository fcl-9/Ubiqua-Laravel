<?php
/**
 * Created by PhpStorm.
 * User: vmcb
 * Date: 14-04-2017
 * Time: 18:28
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Carbon\Carbon;

class ProductController extends Controller
{
    private function getProductWeight($id)
    {
        $product = Product::findOrFail($id);
        if (is_null($product)) {
            return false;
        } else {
            $lots = $product->lot;
            $product_items = $lots->product_item;
            $available_product_items = $product_items->where("state", "IN");
            return $available_product_items->sum("actual_weight");
        }
    }

    private function getToBuyProducts()
    {
        return Product::where("state", "TOBUY");
    }

    private function updateProductState($state, $id)
    {
        $product_item = Product::findOrFail($id);
        if (is_null($product_item)) {
            return false;
        } else {

            $product_item->state = $state;
            $product_item->save();
            return true;
        }
    }

    public function handleProductStateChange(Request $request, $id)
    {
        if($this->updateProductState($request->state,$id)) {
            return response("OK",200);
        }else {
            return response("Error",400);
        }
    }
}