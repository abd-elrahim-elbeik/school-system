<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth', 'verified' ]],
function(){
    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    Route::resource('grades',GradeController::class);
    Route::resource('classrooms',ClassroomController::class);

    Route::post('delete_all',[ClassroomController::class,'delete_all'])->name('delete_all');
    Route::post('filter_classes',[ClassroomController::class,'Filter_Classes'])->name('filter_classes');

    Route::resource('sections',SectionController::class);

    Route::get('/classes/{id}',[SectionController::class,'getclasses']);

    Route::view('add_parent','livewire.show_Form');



});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
