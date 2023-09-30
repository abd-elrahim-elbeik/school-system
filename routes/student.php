<?php

use App\Http\Controllers\Home\Student\ExamsController;
use App\Http\Controllers\Home\Student\ProfileController;
use Illuminate\Http\Request;
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
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:student']
    ], function () {

    //==============================dashboard============================
    Route::get('/student/dashboard', function () {
        return view('pages.Students.dashboard.dashboard');

    })->name('student.dashboard');

    Route::resource('student_exams', ExamsController::class);

    Route::get('profile-student', [ProfileController::class,'index'])->name('profile-student.show');
    Route::post('profile-student/{id}', [ProfileController::class,'update'])->name('profile-student.update');


});
