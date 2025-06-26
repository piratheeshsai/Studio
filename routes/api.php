<?php

use App\Http\Controllers\Admin\ShootController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/packages', [ShootController::class, 'index']);

Route::post('/shoots', [ShootController::class, 'store']);

Route::get('/shoots', [ShootController::class, 'shoot']);
