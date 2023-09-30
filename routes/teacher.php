<?php

use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\Dashboard\StudentController;
use App\Http\Controllers\Home\Teacher\ProfileController;
use App\Http\Controllers\Home\Teacher\QuestionController;
use App\Http\Controllers\Home\Teacher\QuizzController;
use App\Http\Controllers\Home\Teacher\TeacherHomeController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| student Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//==============================Translate all pages============================
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:teacher']
    ],
    function () {

        //==============================dashboard============================
        Route::get('/teacher/dashboard', [TeacherHomeController::class, 'index'])->name('teacher.dashboard');

        Route::get('student', [TeacherHomeController::class, 'student'])->name('student.index');
        Route::get('sectionss', [TeacherHomeController::class, 'sections'])->name('sections');
        Route::post('attendance', [TeacherHomeController::class, 'attendance'])->name('attendance');
        Route::post('edit_attendance', [TeacherHomeController::class, 'editAttendance'])->name('attendance.edit');
        Route::get('attendance_report', [TeacherHomeController::class, 'attendanceReport'] )->name('attendance.report');
        Route::post('attendance_report', [TeacherHomeController::class, 'attendanceSearch'] )->name('attendance.search');

        Route::resource('quizzes', QuizzController::class);
        Route::resource('questions', QuestionController::class);

        Route::get('profile-teacher', [ProfileController::class,'index'])->name('profile-teacher.show');
        Route::post('profile-teacher/{id}', [ProfileController::class,'update'])->name('profile-teacher.update');

        Route::get('student_quizze/{id}',[QuizzController::class,'student_quizze'])->name('student.quizze');
        Route::post('repeat_quizze', [QuizzController::class,'repeat_quizze'])->name('repeat.quizze');

    }
);
