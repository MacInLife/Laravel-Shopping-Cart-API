<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

# Laravel Shopping Cart API
## Objectifs
- Créer une API Laravel pour une application e-commerce basique.

## Fonctionnalités attendues
- Lister les produits présents en base de données
- Afficher la liste des produits dans le panier (quantité, nom du produit, prix du produit)
- Ajouter un produit dans le panier
- Supprimer un produit du panier
- Vider le panier

## Backend API Laravel
- Créer une API sous Laravel pour mettre en place les fonctionnalités du panier.
Afin de vérifier son bon fonctionnement, ainsi que le respect du cahier des charges et des critères d’évaluation fournis ci-dessous, le code source rendu sera exécuté et vérifié par une suite de tests automatisés écrits par l’enseignant.<br>

**_Attention_ : Sachant que ces fonctionnalités seront vérifiées par des tests automatisés, merci de respecter ces spécifications à la lettre. Ceci inclut notamment : le nom des routes, la structure des objets JSON à produire, les chaines de caractères fournies…**

## Modèle de données
Toutes les données manipulées par l’API doivent être stockées dans une base de données.

```sql
products
    id
    timestamps
    name (type : STRING )
    price (type : FLOAT )
    description (type : TEXT )

carts
    id
    timestamps
    quantity (type : INT , UNSIGNED )
    product_id (type : INT , UNSIGNED ) : "relation avec products"
```

Vous devez créer les migrations et les seeders pour la création de ces tables dans votre base de données.

### A. Crée les 3 fichier directement (Migration, Ressources (fct° index etc..), Controller)
```zsh
php artisan make:model Products -mrc
php artisan make:model Carts -mrc
```

### B. Compléter et lancer les migrations 
Pour les produits : 
```php
 Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->float('price', 8,2);
            $table->text('description');
        });
```

Pour le panier :
```php
  Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('quantity')->unsigned();
            $table->integer('product_id')->unsigned();
        });
```

- Lancer la migration dans la BDD :
`php artisan migrate`

### C. Création des seeders
```zsh
php artisan make:seed ProductsTableSeeder
php artisan make:seed CartsTableSeeder
```

Ajout des imports et complétion du contenu :
- Pour les produits
```php
//Add use Faker
use Faker\Factory as Faker;
use App\Product;
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
```

- Pour le panier
 ```php
//Add use Faker
use Faker\Factory as Faker;
use App\Cart;
public function run()
    {
        //Permet de générer des fausses données 'fr_FR' en français
         $faker = Faker::create('fr_FR');

         //Boucle de création des faux users
         for ($i = 0; $i < 10; $i++) {
             $cart = new Cart();
             $cart->quantity = $faker->randomDigitNotNull();
             $cart->product_id = $faker->numberBetween(1, 9);
             $cart->save();
         }
    }
``` 

Liaison du faux contenu avec la BDD :
 - Appel dans le fichier "DatabaseSeeder.php"
```php
$this->call(ProductsTableSeeder::class);
$this->call(CartsTableSeeder::class);
```

Lancer les fausses données en BDD :
```php artisan db:seed```

## Interfaces
Les routes doivent être capables d’extraire les paramètres passés dans le corps de chaque requête au format `application/json` .<br>
La réponse envoyée par chacune de ces routes doit aussi être au format JSON.

   
| Méthode | URL                   | Action                  | Description                                                   |
| ------- | --------------------- | ----------------------- | ------------------------------------------------------------- |
| GET     | /api/products         | ProductController@index | Liste les produits de la base  de données                     |
| GET     | /api/cart             | CartController@index    | Renvoi les produits et leurs quantités présent dans le panier |
| POST    | /api/cart             | CartController@store    | Ajoute un produit dans le panier                              |
| DELETE  | /api/cart             | CartController@destroy  | Vide le panier                                                |
| DELETE  | /api/cart/{productId} | CartController@delete   | Supprime un produit du panier                                 |

- Dans api.php voici les routes :
```php
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
```

- Dans web.php voici les routes (pas utile pour ce qui est demander):
```php
//Liste les produits de la base  de données    
Route::get('products' , 'ProductController@index')->name('produits');
//Renvoi les produits et leurs quantités présent dans le panier
Route::get('cart' , 'CartController@index')->name('panier');
//Ajoute un produit dans le panier
Route::post('cart' , 'CartController@store');
//Vide le panier (get)
Route::delete('cart' , 'CartController@destroy');
//Supprime un produit du panier  (get)
Route::post('cart/{product_id}' , 'CartController@delete');
```


### Route GET /api/products
Cette route permet de lister les produits de la base de données.
- Propriétés JSON en réponse de chaque requête :
    -  Tableau listant les produits présents en base de données. Pour chaque produit :
       - id
       - created_at
       - updated_at
       - name
       - price
       - description

Dans le controller ProductController :
```php
   public function index(Product $product)
    {
        $products = $product->get();
        //Retourne la vue des produits (produits.blade.php)
        //return view('produits', ['products' => $products]);
        //Retourne la liste des produits en JSON
        return  $products;
    }
```

### Route GET /api/cart
Cette route permet de lister les produits dans le panier de la base de données.
- Propriétés JSON en réponse de chaque requête :
    - Tableau listant les produits dans le panier. Pour chaque produit :
        - id
        - created_at
        - updated_at
        - product_id
        - quantity
        - product
            - id
            - created_at
            - updated_at
            - name
            - price
            - description

```php
  public function index(Cart $cart)
    {
        $c = $cart->with('product')->get();
        return $c;
    }
```

### Route POST /api/cart
Cette route permet d'ajouter un produit dans le panier.
- Propriétés JSON attendues dans le corps de la requête :
    - `product_id` : identifiant unique du produit à ajouter
- Propriétés JSON en réponse de chaque requête :
    - quantity
    - product
    - id
    - created_at
    - updated_at
    - name
    - price
    - description

```php
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
```

Cas d’erreurs :
- si `product_id` n’est pas présent en paramètre de la requête : retourner un code HTTP `422` et le message d'erreur générique de Laravel.
- si `product_id` n’est associé à aucun produit stocké dans la base de données : retourner un code HTTP `404` et le message d'erreur générique de Laravel.

### Route DELETE /api/cart
Cette route permet de vider le panier.
- Propriétés JSON en réponse de chaque requête :
    - retourner un code HTTP `200` et une réponse `null`

```php
 public function destroy( Cart $cart)
    {
       $c = $cart->whereNotNull('id')->delete();
       return  $c;
    }
```
  
### Route DELETE /api/cart/{product_id}
Cette route permet de supprimer un produit du panier.
- Paramètres attendus dans l’URL de la requête :
    - `product_id` : identifiant unique du produit à supprimer du panier
- Propriétés JSON en réponse de chaque requête :
    - Retourner un code HTTP `200` et une réponse `null`

```php
    public function delete(Cart $cart, Request $request)
    {
       $c = $cart->where('product_id', '=', $request->product_id)->delete();
      return  $c;
    }
```

Cas d’erreurs :
- si `product_id` n’est associé à aucun produit stocké dans la base de données : retourner un code HTTP `404` et le message d'erreur générique de Laravel.


## Mise en production
Vous avez le choix de mettre en production sur le serveur de choix.
Vous pouvez utiliser **Heroku** pour déployer votre application web.

[https://webstart-laravel-shopping-cart.herokuapp.com/]

## Rendus
Vous devrez fournir les URLs suivantes :
- l'URL du ou des dépôts **GitHub** contenant le code source et l’historique de commits
- l'URL sur laquelle l’**application web et/ou l'API** ont été déployés en production