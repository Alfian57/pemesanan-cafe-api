<?php

use App\Http\Controllers\API\V1\Auth\AuthController;
use App\Http\Controllers\API\V1\Dashboard\CategoryController;
use App\Http\Controllers\API\V1\Dashboard\CategoryMenuController;
use App\Http\Controllers\API\V1\Dashboard\MenuController;
use App\Http\Controllers\API\V1\Dashboard\TableController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);

Route::post('logout', [AuthController::class, 'logout']);

Route::apiResource('tables', TableController::class)->except('show');

Route::apiResource('categories', CategoryController::class);

Route::apiResource('menus', MenuController::class);
Route::post('menus/{menu}/categories/{category}', [CategoryMenuController::class, 'addCategoryToMenu']);
Route::delete('menus/{menu}/categories/{category}', [CategoryMenuController::class, 'removeCategoryFromMenu']);
