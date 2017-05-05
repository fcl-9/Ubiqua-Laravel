<?php

namespace App\Http\Controllers;

use App\Product;
use App\Product_item;
use Illuminate\Http\Request;

class ProductItemController extends Controller
{
    const THRESHOLD = 2;

    public function changeProductItemWeight($weight, $product_item)
    {
        $previous_weight = $product_item->actual_weight;
        $product_item->previous_weight = $previous_weight;
        $product_item->actual_weight = $weight;
        return $product_item;

    }

    public function getProductItemWeight($id)
    {
        $product_item = Product_item::findOrFail($id);
        if (is_null($product_item)) {
            return false;
        }
        else {
            return $product_item->actual_weight;
        }
    }

    public function addNewProductItem($id, $weight, $device_id, $product_id, $lot_id, $distance) {
        $product_item = new Product_item();
        $product_item->id = $id;
        $product_item->previous_weight = 0;
        $product_item->actual_weight = $weight;
        $product_item->distance = $distance;
        $product_item->state = "IN";
        $product_item->lot_id =$lot_id;
        $product_item->device_id = $device_id;
        $product_item->lot_product_id = $product_id;
        $product_item->save();
        $this->updateStockState($product_id);
    }

    public function handleNewProductsInformation(Request $request)
    {
        \DB::transaction(function() use($request){
            $request = $request->json()->all();
            //var_dump($request);
            $device_id = $request["device_id"];
            //var_dump($request["beacons"]);
            $beacons = json_decode($request["beacons"],true);
            //var_dump($beacons);
            try {
                foreach ($beacons as $beacon) {
                    $id = $beacon["uuid"];
                    $product_id = $beacon["major"];
                    $lot_id = $beacon["minor"];
                    $distance = $beacon["distance"];
                    if (!is_null($beacon["weight"])) {
                        $weight = $beacon["weight"];
                    }
                    var_dump( "Qualquer coisa depois do IF");

                    $product_item = $this->getProductItem($id);
                    var_dump($product_item);
                    if (is_null($product_item)) {
                        // product_item is new
                        var_dump("There are product that don't exist.");
                        $this->addNewProductItem($id, $weight, $device_id, $product_id, $lot_id, $distance);
                    } else {
                        var_dump("Qualquer merda uma mensagem para ai");
                        // product_item already exists in DB
                        var_dump($product_item["state"]);
                        if ($product_item->state == "IN") {
                            var_dump("There product already exists.");
                            // Don't need to do anything
                        } else {
                            var_dump("Sem vars");
                            var_dump("Peso: " . $weight . " Product Item : " . $product_item);
                            // change state to IN update weight and distance
                            $this->changeProductItemStateWeightDistance($product_item, $weight, $distance);
                        }
                    }
                }
                // check for missing products
                $actual_products = Product_item::where("state", "IN")->get();
                foreach ($actual_products as $actual_product) {
                    $beacon_inside = false;
                    foreach ($beacons as $beacon) {
                        if ($actual_product->id == $beacon["uuid"]) {
                            $beacon_inside = true;
                            break;
                        }
                    }
                    if (!$beacon_inside) {
                        // change state to OUT
                        $this->changeProductStateToOUT($actual_product);
                    }
                }
                \DB::commit();
                return response()->json(["message" => "success"]);
            }
            catch (\Exception $e) {
                \DB::rollBack();
                var_dump($e->getMessage());
                throw $e;
                //return response()->json(["message" => "error: ".$e->getMessage()]);
            }
        });
    }

    public function getProductItem($id)
    {
        var_dump($id);
        $var = Product_item::find($id);
        var_dump($var);
        return $var;
    }

    private function changeProductItemWeightDistance($product_item, $weight, $distance)
    {
        $product_item = $this->changeProductItemWeight($weight,$product_item);
        $product_item->distance = $distance;
        $product_item->save();
    }

    private function changeProductItemStateWeightDistance($product_item, $weight, $distance)
    {
        $product_item->state ="IN";
        $product_item = $this->changeProductItemWeight($weight,$product_item);
        $product_item->distance = $distance;
        $product_item->save();
        var_dump("Savving Product");
        $this->updateStockState($product_item->lot_product_id);
    }

    private function getNewProductWeight($product_id)
    {
        return Product::find($product_id)->default_weight;
    }

    private function getExistingProductNewWeight($total_weight)
    {
        $total_product_weight = \DB::table("product_item")->where("state", "IN")->sum("actual_weight");
        return $total_weight - $total_product_weight;
    }

    private function changeProductStateToOUT($actual_product)
    {
        $actual_product->state = "OUT";
        $actual_product->save();
        $this->updateStockState($actual_product->lot_product_id);
    }

    private function updateStockState($product_id) {

        $product = Product::find($product_id);
        $product_lots = $product->lot;
        $items_available = 0;
        foreach ($product_lots as $lot) {
            $items_available += $lot->product_item->where("state","IN")->count();
        }
        if ($items_available >= self::THRESHOLD) {
            $product->state = "ONSTOCK";
        }
        else {
            $product->state = "TOBUY";
        }
        $product->save();

    }

    public function getItem(Request $request, $id)
    {
        $product_item = $this->getProductItem($id);
        if(is_null($product_item)) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        else {
            if ($request->has('state')) {
                if ($product_item->state == $request->state) {
                    return response()->json([
                        'message' => 'Record exists',
                    ], 200);
                }
                else {
                    return response()->json([
                        'message' => 'Record not found',
                    ], 404);
                }
            }
            else {
                return response()->json([
                    'message' => 'Expecting state query string',
                ], 400);
            }
        }
    }
}
