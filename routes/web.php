<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/tasks/search/form', function () {
        return view('tasks.search_form');
    })->name('tasks.search.form');

    Route::get('/tasks/search', [TaskController::class, 'search'])->name('tasks.search');
    Route::resource('/tasks', TaskController::class)->only(['index', 'create', 'store', 'search']);
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])->name('comments.store');
});
