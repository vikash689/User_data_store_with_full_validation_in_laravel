<?php


use App\Http\Controllers\ApiUserController;
use Illuminate\Support\Facades\Route;



Route::post('/user_store', [ApiUserController::class, 'store']);
Route::get('/users', [ApiUserController::class, 'index']);
