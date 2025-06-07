<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\extraFeeController;

Route::get('/register', [RegisterController::class, 'showRegistrationForm']);
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', [RegisterController::class, 'showLoginForm']);
Route::post('/login', [RegisterController::class, 'login'])->name('login');


 Route::group(['middleware' => 'school'], function () {

Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');

Route::get('/student', [StudentController::class, 'listStudents'])->name('list');
 Route::get('/addstudent', [StudentController::class, 'addStudents'])->name('add');
 Route::post('/addstudent', [StudentController::class, 'insertStudents'])->name('student.insert');
//  Route::get('/addstudent', [StudentController::class, 'addStu'])->name('add');
// Route::get('/student', [DashboardController::class, 'showDashboard'])->name('dashboard');
// Route::get('/student', [DashboardController::class, 'showDashboard'])->name('dashboard');





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
});