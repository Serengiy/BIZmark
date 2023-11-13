<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', HomeController::class)->name('home');
Route::get('/movies/{movie:slug}', [MovieController::class, 'show'])->name('movies.show');
Route::get('/movies/{movie:slug}/edit', [MovieController::class, 'edit'])->name('movie.edit');
Route::post('/movies/{movie}/update', [MovieController::class, 'update'])->name('movie.update');
Route::post('/movies/{movie}/favorites', [MovieController::class, 'toggleFav'])->name('toggleFav');
Route::post('/comment/{movie}', [CommentController::class, 'store'])->middleware('auth')->name('commentStore');
Route::get('/favorites', [UserController::class, 'index'])->middleware('auth')->name('favorites');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
