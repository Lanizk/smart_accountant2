<?php

use Illuminate\Support\Facades\Route;

Route::get('/try', function () {
    return view('try');
});

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ClassFeeController;
use App\Http\Controllers\extraFeeController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\InvoiceController;


Route::get('/register', [RegisterController::class, 'showRegistrationForm']);
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', [RegisterController::class, 'showLoginForm']);
Route::post('/login', [RegisterController::class, 'login'])->name('login');


 Route::group(['middleware' => 'school'], function () {

Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');

Route::get('/student', [StudentController::class, 'listStudents'])->name('listStudents');
Route::get('/addstudent', [StudentController::class, 'addStudents'])->name('addStudents');
Route::post('/addstudent', [StudentController::class, 'insertStudents'])->name('insertStudents');
Route::get('/editstudent/{id}', [StudentController::class, 'editStudents'])->name('editStudents');
Route::post('/editstudent/{id}', [StudentController::class, 'updateStudents'])->name('updateStudent');
Route::get('/deletestudent/{id}', [StudentController::class, 'deleteStudent'])->name('deleteStudent');





Route::get('/class', [ClassController::class, 'listClass'])->name('classlist');
Route::get('/addClass', [ClassController::class, 'addClass'])->name('addclass');
Route::post('/addClass', [ClassController::class, 'insert'])->name('insertclass');
Route::post('/editClass/{id}', [ClassController::class, 'edit'])->name('editclass');
Route::get('/editClass/{id}', [ClassController::class, 'update'])->name('updateclass');
Route::get('/deleteClass/{id}', [ClassController::class, 'delete'])->name('deleteclass');
// Route::get('/student', [DashboardController::class, 'showDashboard'])->name('dashboard');
// Route::get('/student', [DashboardController::class, 'showDashboard'])->name('dashboard');


Route::get('/extrafee', [extraFeeController::class, 'list'])->name('extrafeelist');
Route::get('/addextrafee', [extraFeeController::class, 'add'])->name('extrafeeadd');
Route::post('/extrafee', [extraFeeController::class, 'insert'])->name('extrafeeinsert');
// Route::get('/student', [DashboardController::class, 'showDashboard'])->name('dashboard');
// Route::get('/student', [DashboardController::class, 'showDashboard'])->name('dashboard');


Route::get('/term', [TermController::class, 'listTerm'])->name('termlist');
Route::get('/addterm', [TermController::class, 'addTerm'])->name('addterm');
Route::post('/addterm', [TermController::class, 'insertTerm'])->name('insertterm');
Route::post('/editterm/{id}', [TermController::class, 'editterm'])->name('editterm');
Route::get('/editterm/{id}', [TermController::class, 'updateterm'])->name('updateterm');
Route::get('/deleteterm/{id}', [TermController::class, 'delete'])->name('deleteterm');


Route::get('/classfee', [ClassFeeController::class, 'listClassFee'])->name('classfeelist');
Route::get('/addclassfee', [ClassFeeController::class, 'addclassfee'])->name('addclassfee');
Route::post('/addclassfee', [ClassFeeController::class, 'insertclassfee'])->name('insertclassfee');
Route::get('/editclassfee/{id}', [ClassFeeController::class, 'editclassfee'])->name('editclassfee');
Route::post('/editclassfee/{id}', [ClassFeeController::class, 'updateclassfee'])->name('updateclassfee');
Route::get('/deleteclassfee/{id}', [ClassFeeController::class, 'deleteclassfee'])->name('deleteclassfee');


Route::get('/extrafee', [ExtraFeeController::class, 'listExtraFee'])->name('extrafeelist');
Route::get('/addextrafee', [ExtraFeeController::class, 'addExtraFee'])->name('addextrafee');
Route::post('/addextrafee', [ExtraFeeController::class, 'insertExtraFee'])->name('insertextrafee');
Route::post('/editextrafee/{id}', [ExtraFeeController::class, 'editExtraFee'])->name('editextrafee');
Route::get('/editextrafee/{id}', [ExtraFeeController::class, 'updateExtraFee'])->name('updateextrafee');
Route::get('/deleteextrafee/{id}', [ExtraFeeController::class, 'deleteExtraFee'])->name('deleteextrafee');

Route::get('/assignextrafee', [ExtraFeeController::class, 'showAssignExtraFeeForm'])->name('assignextrafeeform');
Route::post('/assignextrafee', [ExtraFeeController::class, 'assignStudentExtraFee'])->name('assignextrafee');
Route::get('/listextrafeestudents', [ExtraFeeController::class, 'listExtraFeeStudent'])->name('listextrafeestudents');
Route::get('/assign-extra-fee/edit/{id}', [ExtraFeeController::class, 'editAssignedExtraFee'])->name('editassignedextrafee');
Route::post('/assign-extra-fee/edit/{id}', [ExtraFeeController::class, 'updateAssignedExtraFee'])->name('updateassignedextrafee');
Route::get('/assign-extra-fee/delete/{id}', [ExtraFeeController::class, 'deleteAssignedExtraFee'])->name('deleteassignedextrafee');



Route::prefix('invoices')->group(function () {
    Route::get('/', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
   
    Route::post('{invoice}/payments', [InvoiceController::class, 'storePayment'])->name('payments.store');
});
});