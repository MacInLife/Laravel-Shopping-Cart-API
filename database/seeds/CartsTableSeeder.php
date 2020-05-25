<?php

use Illuminate\Database\Seeder;
//Add use Faker
use Faker\Factory as Faker;
use App\Cart;

class CartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         //Permet de générer des fausses données 'fr_FR' en français
         $faker = Faker::create('fr_FR');

         //Boucle de création des faux users
         for ($i = 0; $i < 10; $i++) {
             $cart = new Cart();
             $cart->quantity = $faker->randomDigit();
             $cart->product_id = $faker->numberBetween(1, 9);
         }
    }
}
