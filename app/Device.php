<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    public function product_item(){
        return $this->hasMany('App\Product_item');
    }
}
