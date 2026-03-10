<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CookBookController;
use App\Http\Controllers\CopyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//for auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
//for category
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::patch('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
//for cookbook
Route::get('/cookbooks', [CookBookController::class, 'index']);
Route::post('/cookbooks', [CookBookController::class, 'store']);
Route::patch('/cookbooks/{id}', [CookBookController::class, 'update']);
Route::delete('/cookbooks/{id}', [CookBookController::class, 'destroy']);
Route::get('/categories/{id}/cookbooks', [CookBookController::class, 'byCategory']);
Route::get('/categories/{id}/cookbooks/popular', [CookbookController::class, 'mostPopular']);
Route::get('/categories/{id}/cookbooks/new', [CookbookController::class, 'newArrivals']);
//for copy
Route::post('/copies', [CopyController::class, 'store']);
Route::get('/cookbooks/{id}/copies', [CopyController::class, 'cookbookCopies']);
Route::patch('/copies/{id}', [CopyController::class, 'update']);
Route::delete('/copies/{id}', [CopyController::class, 'destroy']);

//for dashboard
Route::get('/statistics', [StatisticsController::class, 'index']);
Route::get('/cookbooks/degraded', [StatisticsController::class, 'degradedBooks']);

//for borrow
Route::post('/borrows', [BorrowController::class, 'store']);
Route::patch('/borrows/{id}/return', [BorrowController::class, 'returnBook']);
Route::get('/borrows', [BorrowController::class, 'index']);

// Route::middleware('auth:sanctum')->group(function () {

// });

Route::get('/test', function () {
    return "API working";
});
