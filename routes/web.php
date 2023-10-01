<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupMemberController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TimetableController;
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


Route::get('/sign-up', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/sign-up', [RegisterController::class, 'store']);

Route::get('/sign-in', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/sign-in', [LoginController::class, 'authenticate']);
Route::get('/forgot-password', [LoginController::class, 'forgot_password_view']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::put('/change-password', [LoginController::class, 'updatePassword'])->middleware('auth');

Route::get('/', [UserController::class, 'index'])->middleware('auth');
Route::get('/reminder', [UserController::class, 'reminder'])->middleware('auth');
Route::get('/ongoing', [UserController::class, 'ongoing'])->middleware('auth');
Route::get('/upcoming', [UserController::class, 'upcoming'])->middleware('auth');
Route::get('/profile/{id}', [UserController::class, 'profile_view'])->middleware('auth');
Route::get('/profile/{id}/edit', [UserController::class, 'edit_view'])->middleware('auth');
Route::get('/profile/{id}/password', [UserController::class, 'password_view'])->middleware('auth');
Route::put('/profile', [UserController::class, 'update'])->middleware('auth');
Route::delete('/account', [UserController::class, 'destroy'])->middleware('auth');

Route::post('/users/{id}/profile-picture', [ImageController::class, 'changeProfilePicture'])->middleware('auth');
Route::delete('/users/{id}/profile-picture', [ImageController::class, 'delete'])->middleware('auth');

Route::get('/groups', [GroupController::class, 'index'])->middleware('auth');
Route::get('/groups/create', [GroupController::class, 'indexCreate'])->middleware('auth');
Route::post('/groups', [GroupController::class, 'create'])->middleware('auth');
Route::get('/groups/{id}/detail', [GroupController::class, 'detail'])->middleware('auth');
Route::delete('/groups/{id}', [GroupController::class, 'destroy'])->middleware('auth');
Route::get('/groups/join', [GroupController::class, 'join_view'])->middleware('auth');
Route::post('/groups/join', [GroupController::class, 'join'])->middleware('auth');
Route::get('/groups/join/redirect', [GroupController::class, 'join_redirect'])->middleware('auth');
Route::get('/groups/join/scan', [GroupController::class, 'scan'])->middleware('auth');
Route::post('/groups/join/qr-image', [GroupController::class, 'join_by_upload_qr'])->middleware('auth');
Route::delete('/groups/{group_id}/member/{member_id}', [GroupMemberController::class, 'destroy'])->middleware('auth');
Route::put('/groups/{group_id}/member/{member_id}/role', [GroupMemberController::class, 'destroy'])->middleware('auth');

Route::get('/notifications', [NotificationController::class, 'index'])->middleware('auth');
Route::get('/invitations', [InvitationController::class, 'index'])->middleware('auth');
Route::put('/invitations/{id}/accept', [InvitationController::class, 'accept'])->middleware('auth');
Route::put('/invitations/{id}/decline', [InvitationController::class, 'decline'])->middleware('auth');

Route::post('/groups/{id}/invite', [InvitationController::class, 'create'])->middleware('auth');

Route::get('/timetables/{group_id}/new', [TimetableController::class, 'viewCreate'])->middleware('auth');
Route::post('/timetables', [TimetableController::class, 'create'])->middleware('auth');
Route::delete('/timetables/{id}', [TimetableController::class, 'delete'])->middleware('auth');
