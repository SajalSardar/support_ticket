<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SourceController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('source-list', [SourceController::class, 'index']);
Route::get('status-list', [StatusController::class, 'index']);
Route::get('category-list', [CategoryController::class, 'index']);
Route::post('store-request', [TicketController::class, 'store']);