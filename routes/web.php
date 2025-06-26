<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AnnouncementController;
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

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Organizations - All users can view, Admin can manage all, Org Admin can manage their own
    Route::resource('organizations', OrganizationController::class);
    Route::get('organizations/{organization}/members', [MemberController::class, 'index'])->name('organizations.members');
    Route::get('/api/organizations', [OrganizationController::class, 'getOrganizations'])->name('organizations.api');

    // Users - Only Admin can manage
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    });

    // Members - Admin can manage all, Org Admin can manage their organization, Members can view their organization
    Route::resource('members', MemberController::class);
    Route::get('/members/export', [MemberController::class, 'export'])->name('members.export');

    // Events - Admin can manage all, Org Admin can manage their organization, Members can view their organization
    Route::resource('events', EventController::class);

    // Documents - Admin can manage all, Org Admin can manage their organization, Members can view published docs
    Route::resource('documents', DocumentController::class);
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');

    // Announcements - Admin can manage all, Org Admin can manage their organization, Members can view active announcements
    Route::resource('announcements', AnnouncementController::class);
});

require __DIR__ . '/auth.php';
