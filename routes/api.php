<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\PostsController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/categories', [CategoriesController::class, 'index']);
// Route::post('/categories', [CategoriesController::class, 'store']);
// Route::get('/categories/{category}', [CategoriesController::class, 'show']);
// Route::patch('/categories/{category}', [CategoriesController::class, 'update']);
// Route::delete('/categories/{category}', [CategoriesController::class, 'destroy']);

Route::apiResource('categories', CategoriesController::class);
Route::apiResource('posts', PostsController::class);
Route::get('/categories/{category}/posts', [PostsController::class, 'postsByCategory']) // ->middleware('nombredelmiddleware');
    ->name('category.posts');
