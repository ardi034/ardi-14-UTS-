<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


use App\Http\Controllers\StudentController;

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('student', App\Http\Controllers\StudentController::class);
Route::resource('students', StudentController::class);

Route::get('students/{id}/edit', [StudentController::class, 'edit'])->name('edit.blade');


Route::delete('students/{id}', [StudentController::class, 'destroy'])->name('delete.blade');

