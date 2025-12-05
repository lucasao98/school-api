<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeachersController;
use Illuminate\Support\Facades\Route;

Route::post('/signin', [AuthController::class, 'signIn']);

Route::prefix('teachers')->controller(TeachersController::class)->middleware('auth:sanctum', 'abilities:admin')->group(function () {
    Route::get('/', 'all');
    Route::post('/', 'store');
    Route::get('/{teacherId}', 'find');
    Route::patch('/{teacherId}', 'update');
    Route::delete('/{teacherId}', 'destroy');
});
