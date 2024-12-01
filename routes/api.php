<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('ShowCourse',[CourseController::class,'create']);
Route::post('AddCourse',[CourseController::class,'insert']);
Route::get('EditCourse/{id}',[CourseController::class,'edit']);
Route::put('/UpdateCourse/{id}', [CourseController::class, 'update']);
Route::delete('/DeleteCourse/{id}', [CourseController::class, 'delete']);


Route::get('ShowStudent',[StudentController::class,'create']);
Route::post('AddStudent',[StudentController::class,'insert']);
Route::post('AddStudent',[StudentController::class,'store']);
Route::get('EditStudent/{id}',[StudentController::class,'edit']);
Route::put('/UpdateStudent/{id}', [StudentController::class, 'update']);
// Route::delete('/DeleteStudent/{id}', [StudentController::class, 'delete']);

Route::post('AddStudentCourse',[StudentController::class,'enroll']);
Route::get('ShowStudentCourses/{student_id}', [StudentController::class, 'showStudentCourses']);

Route::delete('/DeleteStudent/{id}', [StudentController::class, 'destroy']);