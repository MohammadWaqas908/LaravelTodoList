<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodolistController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[TodolistController::class,'index'])->name('todo.index');
Route::post('todoList/store',[TodolistController::class,'store'])->name('todoList.store');
Route::post('todoList/update',[TodolistController::class,'update'])->name('todoList.update');
Route::post('todoList/delete',[TodolistController::class,'delete'])->name('todoDelete');
Route::post('todoList/changeStatus',[TodolistController::class,'changeStatus'])->name('changeStatus');
Route::post('todoList/filter',[TodolistController::class,'show'])->name('todolistFilter');
