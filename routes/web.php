<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('colors', \App\Http\Controllers\ColorController::class);

Route::middleware([
    'auth',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::group(['middleware' => ['permission:role.view']],function () {
        Route::get('/roles', App\Livewire\Roles\Index::class)->name('roles');
    });

    Route::group(['middleware' => ['permission:user.view']],function () {
            Route::get('/users', App\Livewire\Users\Index::class)->name('users');
    });

    Route::group(['middleware' => ['permission:task.view']],function () {
        Route::get('/tasks',App\Livewire\Tasks\Index::class)->name('tasks.index');
    });

    Route::group(['middleware' => ['permission:task.edit']],function () {
        Route::get('/tasks/{task}/{editable?}', [\App\Http\Controllers\TaskController::class,'edit'])->name('tasks.edit');
    });

});
