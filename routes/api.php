<?php

use App\Http\Controllers\API\V1\Auth\AuthController;
use App\Http\Controllers\API\V1\Dashboard\CategoryController;
use App\Http\Controllers\API\V1\Dashboard\CategoryMenuController;
use App\Http\Controllers\API\V1\Dashboard\MenuController;
use App\Http\Controllers\API\V1\Dashboard\OrderController;
use App\Http\Controllers\API\V1\Dashboard\TableController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
    });

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
    });

    Route::prefix('dashboard')->middleware('auth:sanctum')->group(function () {
        Route::apiResource('tables', TableController::class)->except('show');

        Route::apiResource('categories', CategoryController::class);

        Route::apiResource('menus', MenuController::class);
        Route::post('menus/{menu}/categories/{category}', [CategoryMenuController::class, 'addCategoryToMenu']);
        Route::delete('menus/{menu}/categories/{category}', [CategoryMenuController::class, 'removeCategoryFromMenu']);

        Route::apiResource('orders', OrderController::class)->only('index', 'show');
    });
});
