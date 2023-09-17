<?php

use App\Http\Controllers\Das\ClassRoomController;
use App\Http\Controllers\Das\GradesController;
use App\Http\Controllers\Das\SectionController;
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
Route::get('/grade_sections', [SectionController::class, 'index']);
//Route::get('/classRooms', [ClassRoomController::class, 'index']);
