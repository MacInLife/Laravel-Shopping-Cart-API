<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
     //Gestion de la liaison entre les 2 tables
     public function product(){
        return $this->belongsTo(\App\Product::class);
    }
}
