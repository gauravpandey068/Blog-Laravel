<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\post\LikeController;
use App\Http\Controllers\post\PostController;
use App\Http\Controllers\post\UserPostController;
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

//Post Like/Unlike
Route::post('/home/post/{post}/like', [LikeController::class, 'store'])->name('post.like');
Route::post('/home/post/{post}/unlike', [LikeController::class, 'unlike'])->name('post.unlike');

//Post Comments
Route::post('/home/{post}/comment/', [CommentController::class, 'store'])->name('post.comment.store');
Route::patch('/home/{post}/comment/{comment}', [CommentController::class, 'update'])->name('post.comment.update');
Route::delete('/home/{post}/comment/{comment}', [CommentController::class, 'destroy'])->name('post.comment.destroy');

//User's Posts
Route::get('/dashboard/user/posts', [UserPostController::class, 'index'])->name('user.posts');
