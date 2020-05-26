<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
//Affiche tous les produits
Route::apiResource('/products', 'ProductController');
//Affiche le panier
Route::apiResource('/cart', 'CartController');
 //Liste les produits de la base  de données    
Route::get('products' , 'ProductController@index');
//Renvoi les produits et leurs quantités présent dans le panier
Route::get('cart' , 'CartController@index');
//Ajoute un produit dans le panier
Route::post('cart' , 'CartController@store');
//Vide le panier (get)
//Route::middleware('api')->delete('cart', 'CartController@destroy');
Route::delete('cart' , 'CartController@destroy');
//Supprime un produit du panier  (get)
//Route::middleware('api')->delete('cart/{product_id}', 'CartController@delete');
Route::post('cart/{product_id}' , 'CartController@delete');
