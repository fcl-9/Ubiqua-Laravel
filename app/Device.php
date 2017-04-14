<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'device';

    public function product_item(){
        return $this->hasMany('App\Product_item');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
