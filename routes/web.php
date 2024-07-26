<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

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
Route::get('/', [SiteController::class,'index']);
Route::post('student', [SiteController::class,'student'])->name('student.create');
Route::get('checkAnswer/{id}', [SiteController::class,'checkAnswer'])->name('checkAnswer');
Route::prefix('admin')->group(function () {
    Route::get('/', [QuestionController::class,'index']);
    Route::resource('questions', QuestionController::class);
});

