<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TodoController;
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

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/registration', [RegistrationController::class, 'show'])->name('registration');
Route::post('/registration', [RegistrationController::class, 'create']);

// group
Route::group([
    // 'middleware',
    'prefix' => 'group',
    'as' => 'group.',
], function () {
    Route::get('/', [GroupController::class, 'show'])->name('show');

    // todo
    Route::group([
        // 'middleware',
        'prefix' => 'todo',
        'as' => 'todo.',
    ], function () {
        Route::get('/{group}', [TodoController::class, 'show'])->name('show');
        Route::get('/{group}/add/{status}', [TodoController::class, 'add'])->name('add');
        Route::post('/{group}/create/{status}', [TodoController::class, 'create'])->name('create');
        Route::get('/{group}/edit/{status}/{todo}', [TodoController::class, 'edit'])->name('edit');
        Route::post('/{group}/update/{status}/{todo}', [TodoController::class, 'update'])->name('update');
        Route::delete('/{group}/delete/{todo}', [TodoController::class, 'delete'])->name('delete');
    });
});

