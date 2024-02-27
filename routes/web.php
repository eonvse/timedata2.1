<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\TasksIndex;

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

Route::resource('colors', \App\Http\Controllers\ColorController::class);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/tasks',[\App\Http\Controllers\TaskController::class,'index'])->name('tasks.index');
    Route::get('/tasks/{task}/{editable?}', [\App\Http\Controllers\TaskController::class,'edit'])->name('tasks.edit');

    Route::get('/test',TasksIndex::class)->name('tasks.test');
});
