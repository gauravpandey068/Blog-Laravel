<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\post\PostController;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

//Post
Route::get('/dashboard/post', [PostController::class, 'index'])->name('post');
Route::post('/dashboard/post', [PostController::class, 'store']);
Route::patch('/dashboard/post/{id}', [PostController::class, 'update'])->name('post.update');
Route::get('/dashboard/post/{id}', [PostController::class, 'edit'])->name('post.edit');
Route::delete('/dashboard/post/{id}', [PostController::class, 'destroy'])->name('post.destroy');
Route::get('/home/post/{id}', [PostController::class, 'show'])->name('post.show');

