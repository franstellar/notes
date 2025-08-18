<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\checkIsNotLogged;

//auth routes - user not logged in
Route::middleware([checkIsNotLogged::class])->group(function () {
    Route::get('/login', [AuthController::class, 'login']);
    Route::post('/authenticate', [AuthController::class, 'authenticate']);
});

//main routes - user logged in
Route::middleware([checkIsLogged::class])->group(function () {
    Route::get('/', [MainController::class, 'index']);
    Route::get('/newNote', [MainController::class, 'newNote']);
    Route::get('/logout', [AuthController::class, 'logout']); 
});
