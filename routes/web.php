<?php

use App\Http\Controllers\Dashboard\ClassroomController;
use App\Http\Controllers\Dashboard\GradeController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\Dashboard\StudentController;
use App\Http\Controllers\Dashboard\TeacherController;
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

    Route::resource('teachers',TeacherController::class);

    Route::resource('students',StudentController::class);

    Route::post('Upload_attachment', 'StudentController@Upload_attachment')->name('Upload_attachment');
    Route::get('Download_attachment/{studentsname}/{filename}', 'StudentController@Download_attachment')->name('Download_attachment');
    Route::post('Delete_attachment', 'StudentController@Delete_attachment')->name('Delete_attachment');


    //for ajax code
    Route::get('/classes/{id}',[SectionController::class,'getclasses']);
    Route::get('/Get_classrooms/{id}', [StudentController::class,'Get_classrooms']);
    Route::get('/Get_Sections/{id}', [StudentController::class,'Get_Sections']);


    Route::view('add_parent','livewire.show_Form');



});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
