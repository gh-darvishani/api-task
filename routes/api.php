<?php
    
    use Illuminate\Support\Facades\Route;
    
    Route::apiResource('product' , 'Api\ProductController')
        ->only([ 'store' , 'update' , 'destroy' ])
        ->parameter('product' , 'id');
    
    
    Route::namespace('Api')->prefix('product')->name('product.')->group(function(){
        Route::get('list' , 'ProductController@listProduct')->name('list');
    });
