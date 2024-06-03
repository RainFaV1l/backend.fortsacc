<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use \App\Http\Controllers\Api\ReviewController;
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

Route::middleware('api')->group(function () {
    Route::controller(ReviewController::class)->prefix('reviews')->group(function () {
        Route::middleware('auth:sanctum')->post('/', 'store');
        Route::get('/', 'index');
    });

    Route::controller(\App\Http\Controllers\Api\OrderController::class)->prefix('order')->group(function () {

    });

    Route::apiResources([
        'products' => \App\Http\Controllers\Api\ProductController::class,
        'categories' => \App\Http\Controllers\Api\CategoryController::class,
        'orders' => \App\Http\Controllers\Api\OrderController::class,
        'subscribes' => \App\Http\Controllers\Api\SubscribeController::class,
        'deliveries' => \App\Http\Controllers\Api\DeliveryController::class,
        'news' => \App\Http\Controllers\Api\NewsController::class,
        'news-category' => \App\Http\Controllers\Api\NewsCategoryController::class,
    ]);

    Route::controller(\App\Http\Controllers\Api\CouponController::class)->prefix('coupon')->group(function () {
       Route::get('/', 'index');
       Route::post('/check', 'check');
    });

    Route::get('/slider', [ProductController::class, 'slider']);

    Route::controller(AuthController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
        Route::get('/auth/{provider}', 'redirectToProvider');
        Route::get('/auth/{provider}/callback', 'handleProviderCallback');
        Route::middleware('auth:sanctum')->get('/user', 'user');
        Route::middleware('auth:sanctum')->post('/logout', 'logout');
    });
});
