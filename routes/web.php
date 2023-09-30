<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\AttendanceController;
use App\Http\Controllers\Dashboard\ClassroomController;
use App\Http\Controllers\Dashboard\FeeController;
use App\Http\Controllers\Dashboard\FeesInvoiceController;
use App\Http\Controllers\Dashboard\GradeController;
use App\Http\Controllers\Dashboard\GraduatedController;
use App\Http\Controllers\Dashboard\LibraryController;
use App\Http\Controllers\Dashboard\OnlineClasseController;
use App\Http\Controllers\Dashboard\PaymentStudentController;
use App\Http\Controllers\Dashboard\ProcessingFeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\Dashboard\StudentController;
use App\Http\Controllers\Dashboard\TeacherController;
use App\Http\Controllers\Dashboard\PromotionController;
use App\Http\Controllers\Dashboard\QuestionController;
use App\Http\Controllers\Dashboard\QuizzeController;
use App\Http\Controllers\Dashboard\ReceiptStudentsController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\SubjectController;
use App\Http\Controllers\Home\HomeController;
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

Route::get('/',[HomeController::class,'index'])->name('selection');

Route::get('/dashboard',[HomeController::class,'dashboard'])->name('dashboard');


Route::get('/login/{type}',[LoginController::class,'loginForm'])->middleware('guest')->name('login.show');

Route::post('/login',[LoginController::class,'login'])->name('login');

Route::get('/logout/{type}', [LoginController::class,'logout'])->name('logout');




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

    Route::resource('promotion',PromotionController::class);

    Route::resource('graduated',GraduatedController::class);

    Route::resource('fees',FeeController::class);

    Route::resource('fees_invoices',FeesInvoiceController::class);

    Route::resource('receipt_students',ReceiptStudentsController::class);

    Route::resource('ProcessingFee',ProcessingFeeController::class);

    Route::resource('Payment_students',PaymentStudentController::class);

    Route::resource('attendance',AttendanceController::class);

    Route::resource('subjects',SubjectController::class);

    Route::resource('quizzes',QuizzeController::class);

    Route::resource('questions',QuestionController::class);

    Route::resource('online_classes',OnlineClasseController::class);

    Route::resource('library',LibraryController::class);

    Route::resource('settings', SettingController::class);



    Route::get('download_file/{filename}', [LibraryController::class,'downloadAttachment'])->name('downloadAttachment');
    Route::post('Upload_attachment',[StudentController::class,'Upload_attachment'])->name('Upload_attachment');
    Route::get('Download_attachment/{studentsid}/{filename}', [StudentController::class,'Download_attachment'])->name('Download_attachment');
    Route::post('Delete_attachment', [StudentController::class,'Delete_attachment'])->name('Delete_attachment');



    Route::view('add_parent','livewire.show_Form')->name('add_parent');



});




// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });



require __DIR__.'/auth.php';
