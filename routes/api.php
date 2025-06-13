<?php

use App\Http\Controllers\Api\Ecommerce\ProductController;
use App\Http\Controllers\Api\Ecommerce\CartItemController;
use App\Http\Controllers\Api\Ecommerce\OrderController;
use App\Http\Controllers\Api\Ecommerce\CategoryController;
use App\Http\Controllers\Api\Ecommerce\PaymentController;
use App\Http\Controllers\Api\Ecommerce\ProductImageController;
use App\Http\Controllers\Api\Ecommerce\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


//category
Route::middleware('auth:sanctum')->group(function (){

    Route::get('category' , [CategoryController::class , 'index']);
    Route::post('storeCategory' , [CategoryController::class , 'store']);
    Route::get('category/{id}' , [CategoryController::class , 'show']);
    Route::post('updateCategory/{id}' , [CategoryController::class , 'update']);
    Route::get('deleteCategory/{id}' , [CategoryController::class , 'delete']);

});


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


//payment
Route::middleware('auth:sanctum')->group(function (){
    Route::get('payments' , [PaymentController::class , 'index']);
    Route::post('payStorePayment' , [PaymentController::class , 'pay']);
    Route::get('payment/{id}' , [PaymentController::class , 'show']);
    Route::get('deletePayment/{id}' , [PaymentController::class , 'delete']);
});



//Product Imagee
Route::middleware('auth:sanctum')->group(function (){

    Route::post('storeImage' , [ProductImageController::class , 'store']);
    Route::get('image/{id}' , [ProductImageController::class , 'show']);
    Route::get('deleteImage/{id}' , [ProductImageController::class , 'delete']);
});


Route::middleware('auth:sanctum')->group(function (){

    Route::get('reviews' , [ReviewController::class , 'index']);
    Route::post('StoreRating' , [ReviewController::class , 'store']);

});


