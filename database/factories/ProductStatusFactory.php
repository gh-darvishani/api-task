<?php
    
    /** @var Factory $factory */
    
    use App\Models\Product;
    use App\Models\ProductStatus;
    use Faker\Generator as Faker;
    use Illuminate\Database\Eloquent\Factory;
    
    /*
    |--------------------------------------------------------------------------
    | Model Factories
    |--------------------------------------------------------------------------
    |
    | This directory should contain each of the model factory definitions for
    | your application. Factories provide a convenient way to generate new
    | model instances for testing / seeding your application's database.
    |
    */
    
    $factory->define(ProductStatus::class , function(Faker $faker){
        return [
            'product_id' => function(){
                return factory(Product::class)->create()->id;
            } ,
            'status' => $faker->randomKey([ 0 , 1 ]) ,
        ];
    });
