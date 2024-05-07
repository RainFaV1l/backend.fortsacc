<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResources([
    'products' => \App\Http\Controllers\Api\ProductController::class,
    'categories' => \App\Http\Controllers\Api\CategoryController::class,
    'orders' => \App\Http\Controllers\Api\OrderController::class,
    'subscribes' => \App\Http\Controllers\Api\SubscribeController::class,
    'reviews' => \App\Http\Controllers\Api\ReviewController::class,
    'deliveries' => \App\Http\Controllers\Api\DeliveryController::class,
]);

Route::get('/slider', [ProductController::class, 'slider']);

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::middleware('auth:sanctum')->get('/user', 'user');
    Route::middleware('auth:sanctum')->post('/logout', 'logout');
});
