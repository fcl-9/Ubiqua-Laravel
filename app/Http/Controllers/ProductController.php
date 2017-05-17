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

    public function getProducts(Request $request)
    {
        if ($request->input('state') == "TOBUY") {
            return $this->getToBuyProducts();
        }
    }

    private function getToBuyProducts()
    {
        return response()->json(Product::where("state", "TOBUY")->get());
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

    public function getNameNotInBuyList(Request $request){
        /*Returns all the names of the products that are not in the shopping lists*/
        if($request->input('state') == "NOTOBUY") {
            $available_products = Product::where('state', '!=','TOBUY')->select('product.id', 'product.name')->get();
            $tobuy_products = [];
            foreach ($available_products as $product){
                $new_product = [];
                $new_product['id'] = $product->id;
                $new_product['name'] = $product->name;
                $quantity = 0;
                $product_lots = $product->lot;
                foreach ($product_lots as $lot){
                    $quantity += $lot->product_item->where("state","IN")->sum("actual_weight");
                }
                $new_product["quantity"] = $quantity;
                array_push($tobuy_products,$new_product);
            }
            $json = array("response" => $tobuy_products);
            return response()->json($json);
        }
        else{
            $json = array("response" => "error");
            return response()->json($json);
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