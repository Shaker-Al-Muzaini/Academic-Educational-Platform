<?php

use App\Http\Controllers\Das\AppControoler;
use App\Http\Controllers\Das\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get('{view}', AppControoler::class)->where('view', '(.*)');
Route::get('/api/user',[UserController::class,'index']);
Route::post('/api/createUser',[UserController::class,'store']);
Route::put('/api/users/{user}',[UserController::class,'update']);
Route::delete('/api/users/{user}',[UserController::class,'destory']);
Route::patch('/api/users/{user}/change-role',[UserController::class,'changeRole']);
