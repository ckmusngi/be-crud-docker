<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix'=>'customers'], function() {
    Route::get('/', [CustomerController::class, 'handleGetAll']);
    Route::get('/{id}', [CustomerController::class, 'handleGetById']);
    Route::post('/', [CustomerController::class, 'handleCreate']);
    Route::put('/{id}', [CustomerController::class, 'handleUpdateById']);
    Route::delete('/{id}', [CustomerController::class, 'handleDeleteById']);
});