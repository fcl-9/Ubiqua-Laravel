<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_item extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_item';

    public function device(){
        return $this->belongsTo('App\Device');
    }

    public function lot(){
        return $this->belongsTo('App\Lot');
    }
}
