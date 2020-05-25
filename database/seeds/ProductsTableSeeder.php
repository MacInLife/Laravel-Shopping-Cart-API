<?php

use Illuminate\Database\Seeder;
//Add use Faker
use Faker\Factory as Faker;
use App\Product;

class ProductsTableSeeder extends Seeder
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
            $product = new Product();
            $product->name = $faker->name();
            $product->price = $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 8);
            $product->description = $faker->text();
            $product->save();
        }
    }
}
