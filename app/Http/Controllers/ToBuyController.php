<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\DB;

class ToBuyController extends Controller
{
    public function index()
    {
        return view('shopping_list')->with('products', $this->getToBuyProducts());
    }


    private function getToBuyProducts()
    {
        //return Product::where("state", "TOBUY")->get();
        return DB::table('product')
            ->join('lot','lot.product_id','=','product.id')
            ->join('product_item',function($join){
                $join->on('lot.product_id','=','product_item.lot_product_id')
                    ->on('lot.id','=','product_item.lot_id');
            })->where('product.state','=','TOBUY')
            ->select('product_item.actual_weight','product.name')->get();
    }
}
