<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

    Route::group(['middleware' => ['permission:role.view|role.edit|role.create|role.delete']],function () {
        Route::get('/roles', App\Livewire\Roles\Index::class)->name('roles');
        });

    Route::group(['middleware' => ['permission:task.view|task.edit|task.create|task.delete']],function () {

        Route::get('/test', App\Livewire\Tasks\Index::class)->name('tasks.test');
        Route::get('/tasks',[\App\Http\Controllers\TaskController::class,'index'])->name('tasks.index');
        Route::get('/tasks/{task}/{editable?}', [\App\Http\Controllers\TaskController::class,'edit'])->name('tasks.edit');

    });

    Route::resources([
        'users' => UserController::class,
    ]);


});
