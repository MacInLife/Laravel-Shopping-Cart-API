<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cart;

class Product extends Model
{
    //
      //Gestion de la liaison entre les 2 tables
      public function cart(){
        return $this->hasMany(Cart::class);
    }
}
