<?php

use App\Http\Controllers\Home\Parent\ChildrenController;
use App\Http\Controllers\Home\Parent\ParentHomeController;
use App\Http\Controllers\Home\Parent\ProfileController;
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
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:parent']
    ],
    function () {

        //==============================dashboard============================

        Route::get('/parent/dashboard', [ParentHomeController::class,'index'])->name('parent.dashboard');


        Route::get('children', [ChildrenController::class,'index'])->name('sons.index');
        Route::get('results/{id}', [ChildrenController::class,'results'])->name('sons.results');

        Route::get('attendances', [ChildrenController::class,'attendances'])->name('sons.attendances');
        Route::post('attendances',[ChildrenController::class,'attendanceSearch'])->name('sons.attendance.search');


        Route::get('profile-parent', [ProfileController::class, 'index'])->name('profile-parent.show');
        Route::post('profile-parent/{id}', [ProfileController::class, 'update'])->name('profile-parent.update');

        Route::get('fees', [ChildrenController::class,'fees'])->name('sons.fees');
        Route::get('receipt/{id}', [ChildrenController::class,'receiptStudent'])->name('sons.receipt');
    }
);
