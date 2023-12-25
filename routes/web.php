<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventMemberController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\ResidentController;
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

Route::get('/sign-up', [AuthController::class, 'registerView']);
Route::post('/sign-up', [AuthController::class, 'register']);

Route::get('/sign-in', [AuthController::class, 'loginView'])->name('login');
Route::post('/sign-in', [AuthController::class, 'login']);
Route::get('/forgot-password', [AuthController::class, 'forgotPasswordView']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth'])->group(function () {
    Route::get('/', [UserController::class, 'homeView']);
    Route::get('/reminder', [UserController::class, 'reminderView']);
    Route::get('/ongoing', [UserController::class, 'ongoingView']);
    Route::get('/upcoming', [UserController::class, 'upcomingView']);
    Route::get('/profile/{id}', [UserController::class, 'profileView']);
    Route::get('/profile/{id}/edit', [UserController::class, 'editView']);
    Route::get('/profile/{id}/password', [UserController::class, 'passwordView']);
    Route::put('/profile', [UserController::class, 'update']);
    Route::put('/profile/email', [AuthController::class, 'updateEmail']);
    Route::delete('/account', [UserController::class, 'delete']);
    Route::put('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/users/{id}/profile-picture', [ImageController::class, 'changeProfilePicture']);
    Route::delete('/users/{id}/profile-picture', [ImageController::class, 'delete']);

    Route::get('/events', [EventController::class, 'indexView']);
    Route::get('/events/{id}/detail', [EventController::class, 'detailView'])->name('eventDetailView');
    Route::get('/events/join', [EventController::class, 'joinView']);
    Route::post('/events/join', [EventController::class, 'join']);
    Route::get('/events/join/redirect', [EventController::class, 'joinRedirect']);
    Route::get('/events/join/scan', [EventController::class, 'scanQRView']);
    Route::post('/events/join/qr-image', [EventController::class, 'joinByUploadQR']);

    Route::get('/notifications', [NotificationController::class, 'indexView']);
    Route::get('/invitations', [InvitationController::class, 'indexView']);
    Route::put('/invitations/{id}/accept', [InvitationController::class, 'accept']);
    Route::put('/invitations/{id}/decline', [InvitationController::class, 'decline']);

    Route::get('/timetables/{event_id}/new', [TimetableController::class, 'createView']);
    Route::get('/timetables/{id}/scan-me', [TimetableController::class, 'scanQRView']);
    Route::get('/timetables/{id}/presences', [PresenceController::class, 'indexView']);

    Route::get('/presences/get-device-information', [PresenceController::class, 'getDeviceInfo']);
    Route::get('/presences/redirect', [PresenceController::class, 'presenceRedirect']);
    Route::get('/presences/history', [PresenceController::class, 'historyView']);

    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'indexView']);
        Route::get('/residents', [ResidentController::class, 'indexView'])->name('residentsAdminView');
        Route::get('/residents/create', [ResidentController::class, 'createView']);
        Route::get('/residents/{id}/edit', [ResidentController::class, 'editView']);
        Route::put('/residents/update', [ResidentController::class, 'update']);
        Route::put('/events', [EventController::class, 'update']);
        Route::post('/residents/create', [ResidentController::class, 'create']);
        Route::delete('/residents', [ResidentController::class, 'delete'])->name('deleteResident');
        Route::get('/users', [UserController::class, 'indexAdminView'])->name('usersAdminView');
        Route::get('/events/admin', [EventController::class, 'indexAdminView'])->name('eventsAdminView');
        Route::get('/events/create', [EventController::class, 'createView']);
        Route::post('/events', [EventController::class, 'create']);
        Route::delete('/events/{id}', [EventController::class, 'delete']);
        Route::delete('/events/{event_id}/member/{member_id}', [EventMemberController::class, 'delete'])->name('deleteMember');
        Route::put('/events/{event_id}/member/{member_id}/role', [EventMemberController::class, '']);
        Route::post('/events/{id}/invite', [InvitationController::class, 'create']);
        Route::post('/timetables', [TimetableController::class, 'create']);
        Route::delete('/timetables/{id}', [TimetableController::class, 'delete'])->name('deleteTimetable');
        Route::put('/timetables', [TimetableController::class, 'update'])->name('updateTimetable');

        Route::get('/admin/events/{id}/edit', [EventController::class, 'editView']);
        Route::get('/admin/events/{id}/detail', [EventController::class, 'detailView']);
        Route::get('/admin/events/{event_id}/members/add', [EventMemberController::class, 'addMembersView'])->name('addMembersView');
        Route::post('/admin/events/member/add', [EventMemberController::class, 'addMembers'])->name('addMembers');
        Route::delete('/admin/users', [UserController::class, 'deleteFromAdmin']);
        Route::get('/admin/timetables/{id}', [TimetableController::class, 'indexAdminView'])->name('timetablesAdminView');
        Route::get('/admin/users/{id}/edit', [UserController::class, 'editFromAdminView'])->name('editUserFromAdminView');
        Route::get('/admin/timetables/{id}/edit', [TimetableController::class, 'editView'])->name('editTimetableView');
        Route::put('/admin/users/edit', [UserController::class, 'editFromAdmin'])->name('editUserFromAdmin');
        Route::get('/admin/event/{event_id}/timetables', [TimetableController::class, 'createFromAdminView'])->name('createTimetableFromAdminView');
    });
});
