<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lot';

    public function product_item(){
        return $this->hasMany('App\Product_item');
    }

    public function product(){
        return $this->belongTo('App\Product');
    }
}
