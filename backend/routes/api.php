<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use Illuminate\Support\Facades\Cache;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});


// Route::middleware('throttle:3,1')->group(function () {
//      Route::post('/login', [AuthController::class, 'login']);
// });


Route::middleware('throttle:api')
 ->post('/login', [AuthController::class, 'login']);

Route::get('/categories', [CategoryController::class, 'index'])
->middleware('throttle:api');

Route::middleware(['auth:sanctum','throttle:api'])->group(function () {
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
});

