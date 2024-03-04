<?php

use App\Http\Controllers\Das\AdminDasController;
use App\Http\Controllers\Das\AppControoler;
use App\Http\Controllers\Das\AppointmentController;
use App\Http\Controllers\Das\ClassRoomController;
use App\Http\Controllers\Das\ClientController;
use App\Http\Controllers\Das\ExplanationController;
use App\Http\Controllers\Das\GradesController;
use App\Http\Controllers\Das\ParentStudentController;
use App\Http\Controllers\Das\ProfileController;
use App\Http\Controllers\Das\SectionController;
use App\Http\Controllers\Das\SettingController;
use App\Http\Controllers\Das\StudentController;
use App\Http\Controllers\Das\TeacherController;
use App\Http\Controllers\Das\UserController;
use App\Models\Explanation;
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



Route::middleware('auth')->group(function () {
    Route::get('/api/user', [UserController::class, 'index']);
    Route::post('/api/createUser', [UserController::class, 'store']);
    Route::put('/api/users/{user}', [UserController::class, 'update']);
    Route::delete('/api/users/{user}', [UserController::class, 'destory']);
    Route::delete('/api/users/', [UserController::class, 'bulkDelete']);
    Route::patch('/api/users/{user}/change-role', [UserController::class, 'changeRole']);

//Appointment
    Route::get('/api/get-appointment-status', [AppointmentController::class, 'getAppointmentStatus']);
    Route::get('/api/appointments', [AppointmentController::class, 'index']);
    Route::post('/api/appointments/create', [AppointmentController::class, 'store']);
    Route::get('/api/appointments/{appointment}/edit', [AppointmentController::class, 'edit']);
    Route::put('/api/appointments/{appointment}/edit', [AppointmentController::class, 'update']);
    Route::delete('/api/appointments/{appointment}', [AppointmentController::class, 'destroy']);


///clients

    Route::get('/api/clients', [ClientController::class, 'index']);

    //Admin Deshboard

    Route::get('/api/stats/appointments',[AdminDasController::class,'index']);
    Route::get('/api/stats/users',[AdminDasController::class,'users']);

    //Settings

    Route::get('/api/settings',[SettingController::class,'index']);
    Route::post('/api/settings',[SettingController::class,'update']);

    //Profiles

    Route::get('/api/profile', [ProfileController::class, 'index']);
    Route::put('/api/profile', [ProfileController::class, 'update']);
    Route::post('/api/upload-profile-image', [ProfileController::class, 'uploadImage']);
    Route::post('/api/change-user-password', [ProfileController::class, 'changePassword']);


    //Grades

    Route::get('/api/grades', [GradesController::class, 'index']);
    Route::get('/api/grade', [GradesController::class, 'index2']);
    Route::post('/api/createGrades', [GradesController::class, 'store']);
    Route::put('/api/grades/{grade}', [GradesController::class, 'update']);
    Route::delete('/api/grades/{grade}', [GradesController::class, 'destroy']);


    //classRoom
    Route::get('/api/classRooms', [ClassRoomController::class, 'index']);
    Route::get('/api/classRoom', [ClassRoomController::class, 'index2']);
    Route::post('/api/createClassRooms', [ClassRoomController::class, 'store']);
    Route::put('/api/classRooms/{classRoom}', [ClassRoomController::class, 'update']);
    Route::delete('/api/classRooms/{classRoom}', [ClassRoomController::class, 'destroy']);
    Route::delete('/api/classRooms/', [ClassRoomController::class, 'bulkDelete']);

   //Sections
    Route::get('/api/grade_sections', [SectionController::class, 'index']);
    Route::get('/api/sections', [SectionController::class, 'index2']);
    Route::post('/api/createSections', [SectionController::class, 'store']);
    Route::put('/api/grade_sections/{section}', [SectionController::class, 'update']);
    Route::delete('/api/grade_sections/{section}', [SectionController::class, 'destroy']);

    //ParentStudent

    Route::post('/api/createParentStudent', [ParentStudentController::class, 'store']);
    Route::get('/api/ParentStudent', [ParentStudentController::class, 'index']);


    //teachers
    Route::get('/api/teachers', [TeacherController::class, 'index']);
    Route::get('/api/specializations', [TeacherController::class, 'index2']);
    Route::get('/api/genders', [TeacherController::class, 'index3']);
    Route::get('/api/Teacher', [TeacherController::class, 'index4']);
    Route::post('/api/teachers', [TeacherController::class, 'store']);
    Route::put('/api/teachers/{teacher}', [TeacherController::class, 'update']);
    Route::delete('/api/teachers/{teacher}', [TeacherController::class, 'destroy']);


    //Students
    Route::get('/api/students', [StudentController::class, 'index']);
    Route::post('/api/students', [StudentController::class, 'store']);
    Route::put('/api/students/{student}', [StudentController::class, 'update']);
    Route::delete('/api/students/{student}', [StudentController::class, 'destroy']);
    Route::get('/api/showStudent/{student}', [StudentController::class, 'show']);



//    Explanation
    Route::get('/api/explanations', [ExplanationController::class, 'index']);







});

Route::get('{view}', AppControoler::class)->where('view', '(.*)')->middleware('auth');
