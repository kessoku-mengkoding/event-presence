<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventMemberController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\UserController;
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

Route::get('/sign-up', [AuthController::class, 'registerView'])->middleware('guest');
Route::post('/sign-up', [AuthController::class, 'register']);

Route::get('/sign-in', [AuthController::class, 'loginView'])->name('login')->middleware('guest');
Route::post('/sign-in', [AuthController::class, 'login']);
Route::get('/forgot-password', [AuthController::class, 'forgotPasswordView']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::put('/change-password', [AuthController::class, 'changePassword'])->middleware('auth');

Route::get('/', [UserController::class, 'homeView'])->middleware('auth');
Route::get('/reminder', [UserController::class, 'reminderView'])->middleware('auth');
Route::get('/ongoing', [UserController::class, 'ongoingView'])->middleware('auth');
Route::get('/upcoming', [UserController::class, 'upcomingView'])->middleware('auth');
Route::get('/profile/{id}', [UserController::class, 'profileView'])->middleware('auth');
Route::get('/profile/{id}/edit', [UserController::class, 'editView'])->middleware('auth');
Route::get('/profile/{id}/password', [UserController::class, 'passwordView'])->middleware('auth');
Route::put('/profile', [UserController::class, 'update'])->middleware('auth');
Route::delete('/account', [UserController::class, 'delete'])->middleware('auth');

Route::post('/users/{id}/profile-picture', [ImageController::class, 'changeProfilePicture'])->middleware('auth');
Route::delete('/users/{id}/profile-picture', [ImageController::class, 'delete'])->middleware('auth');

Route::get('/events', [EventController::class, 'indexView'])->middleware('auth');
Route::get('/events/create', [EventController::class, 'createView'])->middleware('auth');
Route::post('/events', [EventController::class, 'create'])->middleware('auth');
Route::get('/events/{id}/detail', [EventController::class, 'detailView'])->middleware('auth');
Route::delete('/events/{id}', [EventController::class, 'delete'])->middleware('auth');
Route::get('/events/join', [EventController::class, 'joinView'])->middleware('auth');
Route::post('/events/join', [EventController::class, 'join'])->middleware('auth');
Route::get('/events/join/redirect', [EventController::class, 'joinRedirect'])->middleware('auth');
Route::get('/events/join/scan', [EventController::class, 'scanQRView'])->middleware('auth');
Route::post('/events/join/qr-image', [EventController::class, 'joinByUploadQR'])->middleware('auth');
Route::delete('/events/{event_id}/member/{member_id}', [EventMemberController::class, 'delete'])->middleware('auth');
Route::put('/events/{event_id}/member/{member_id}/role', [EventMemberController::class, 'delete'])->middleware('auth');

Route::get('/notifications', [NotificationController::class, 'indexView'])->middleware('auth');
Route::get('/invitations', [InvitationController::class, 'indexView'])->middleware('auth');
Route::put('/invitations/{id}/accept', [InvitationController::class, 'accept'])->middleware('auth');
Route::put('/invitations/{id}/decline', [InvitationController::class, 'decline'])->middleware('auth');

Route::post('/events/{id}/invite', [InvitationController::class, 'create'])->middleware('auth');

Route::get('/timetables/{event_id}/new', [TimetableController::class, 'createView'])->middleware('auth');
Route::post('/timetables', [TimetableController::class, 'create'])->middleware('auth');
Route::delete('/timetables/{id}', [TimetableController::class, 'delete'])->middleware('auth');
Route::get('/timetables/{id}/scan-me', [TimetableController::class, 'scanQRView'])->middleware('auth');
Route::get('/timetables/{id}/presences', [PresenceController::class, 'indexView'])->middleware('auth');

Route::get('/presences/get-device-information', [PresenceController::class, 'getDeviceInfo'])->middleware('auth');
Route::get('/presences/redirect', [PresenceController::class, 'presenceRedirect'])->middleware('auth');
Route::get('/presences/history', [PresenceController::class, 'historyView'])->middleware('auth');
