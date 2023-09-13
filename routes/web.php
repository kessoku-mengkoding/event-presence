<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupMemberController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Models\GroupMember;
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


Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/', [UserController::class, 'index'])->middleware('auth');
Route::get('/profile/{id}', [UserController::class, 'profile'])->middleware('auth');
Route::put('/profile', [UserController::class, 'update'])->middleware('auth');

Route::get('/groups/create', [GroupController::class, 'indexCreate'])->middleware('auth');
Route::post('/groups', [GroupController::class, 'create'])->middleware('auth');
Route::get('/groups/{id}/detail', [GroupController::class, 'detail'])->middleware('auth');
Route::delete('/groups/{id}', [GroupController::class, 'destroy'])->middleware('auth');
Route::post('/groups/join', [GroupController::class, 'join'])->middleware('auth');
Route::post('/groups/join-via-invite', [GroupController::class, 'join'])->middleware('auth');
Route::post('/groups/{id}/invite', [GroupController::class, 'invite'])->middleware('auth');
Route::delete('/groups/{group_id}/member/{member_id}', [GroupMemberController::class, 'destroy'])->middleware('auth');
Route::put('/groups/{group_id}/member/{member_id}/role', [GroupMemberController::class, 'destroy'])->middleware('auth');

Route::get('/notifications', [NotificationController::class, 'index'])->middleware('auth');
