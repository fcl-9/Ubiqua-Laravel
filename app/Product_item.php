<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_item extends Model
{
    public function device(){
        return $this->belongsTo('App\Device');
    }

    public function lot(){
        return $this->belongsTo('App\Lot');
    }
}
