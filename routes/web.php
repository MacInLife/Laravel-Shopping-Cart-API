<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
//Liste les produits de la base  de données    
Route::get('products' , 'ProductController@index')->name('index');
//Renvoi les produits et leurs quantités présent dans le panier
Route::get('cart' , 'CartController@index');
//Ajoute un produit dans le panier
Route::post('cart' , 'CartController@store');
//Vide le panier (get)
Route::delete('cart' , 'CartController@destroy');
//Supprime un produit du panier  (get)
Route::delete('cart/{productId}' , 'CartController@delete');
