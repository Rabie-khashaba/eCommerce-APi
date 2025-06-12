<?php

use App\Http\Controllers\Api\Ecommerce\ProductController;
use App\Http\Controllers\Api\Ecommerce\CartItemController;
use App\Http\Controllers\Api\Ecommerce\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);



//product
Route::middleware('auth:sanctum')->group(function (){
    Route::post('logout',[AuthController::class , 'logout']);

    Route::get('products' , [ProductController::class , 'index']);
    Route::post('storeProduct' , [ProductController::class , 'store']);
    Route::get('product/{id}' , [ProductController::class , 'show']);
    Route::post('updateProduct/{id}' , [ProductController::class , 'update']);
    Route::get('deleteProduct/{id}' , [ProductController::class , 'delete']);

});


//Cart items
Route::middleware('auth:sanctum')->group(function (){
    Route::get('cartItems' , [CartItemController::class , 'index']);
    Route::post('storeCartItems' , [CartItemController::class , 'store']);
    Route::get('cartItem/{id}' , [CartItemController::class , 'show']);
    Route::post('updateCartItem/{id}' , [CartItemController::class , 'update']);
    Route::get('deleteCartItem/{id}' , [CartItemController::class , 'delete']);

});


//Order
Route::middleware('auth:sanctum')->group(function (){
    Route::get('orders' , [OrderController::class , 'index']);
    Route::post('storeOrder' , [OrderController::class , 'store']);
    Route::get('order/{id}' , [OrderController::class , 'show']);
    Route::post('updateOrder/{id}' , [OrderController::class , 'update']);
    Route::get('deleteOrder/{id}' , [OrderController::class , 'delete']);

});
