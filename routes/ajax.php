<?php

use App\Http\Controllers\AjaxController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Ajax Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'auth:teacher,web'], function () {

    //for ajax code
    Route::get('/Get_classrooms/{id}', [AjaxController::class,'Get_classrooms']);
    Route::get('/Get_Sections/{id}', [AjaxController::class,'Get_Sections']);

});
