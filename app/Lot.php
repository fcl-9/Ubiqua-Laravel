<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    public function product_item(){
        return $this->hasMany('App\Product_item');
    }

    public function product(){
        return $this->belongTo('App\Product');
    }
}
