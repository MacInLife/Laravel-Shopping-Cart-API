<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Cart $cart)
    {
        $c = $cart->with('product')->get();
        //SELECT * FROM `carts`, `products` WHERE `carts`.`product_id` = `products`.`id`
        //$cart;
       // $result = DB::table('carts','products')
            // ->where('product_id' , 'products.id')
            // ->get();
        //Retourne la vue des produits (panier.blade.php)
        //return view('index', ['carts' => $c]);
        //Retourne la liste des produits du panier en JsON
        return $c;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Cart $cart)
    {
        //
        //Validation
        $validate = $request->validate([
            'product_id' => 'required',
        ]);

        //Création
        $cart = new Cart;
        $cart->quantity = $request->quantity;
        $cart->product_id = $request->product_id;
     
        //Sauvegarde du produit
        $cart->save();

        //Redirection
        return $cart->with('product')->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Carts  $carts
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Carts  $carts
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Carts  $carts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Carts  $carts
     * @return \Illuminate\Http\Response
     */
    public function destroy( Cart $cart)
    {
       $c = $cart->whereNotNull('id')->delete();
       return  $c;
    }

    
    public function delete(Cart $cart, Request $request)
    {
       $c = $cart->where('product_id', '=', $request->product_id)->delete();
      return  $c;
    }
}
