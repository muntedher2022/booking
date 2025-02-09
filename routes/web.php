<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sections\SectionsController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Departments\DepartmentsController;
use App\Http\Controllers\Incomingbooks\IncomingbooksController;
use App\Http\Controllers\OutgoingBooks\OutgoingBooksController;
use App\Http\Controllers\Users\UsersAccounts\UsersAccountsController;
use App\Http\Controllers\PermissionsRoles\Roles\AccountRolesController;
use App\Http\Controllers\Users\CustomersAccounts\CustomersAccountsController;
use App\Http\Controllers\PermissionsRoles\Permissions\AccountPermissionsController;
use App\Http\Controllers\Users\AdministratorsAccounts\AdministratorsAccountsController;

Route::middleware(['auth', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::GET('/', [DashboardController::class, 'index'])->name('Dashboard');
    // Middleware Owners
    Route::middleware(['role:OWNER|Administrator|Supervisor'])->group(function () {
        // Roles & Permission
        Route::GROUP(['prefix' => 'Permissions&Roles'], function () {
            Route::RESOURCE('Account-Permissions', AccountPermissionsController::class);
            Route::RESOURCE('Account-Roles', AccountRolesController::class);
        });
        // Users Accounts
        Route::RESOURCE('Administrators-Accounts', AdministratorsAccountsController::class);
        Route::RESOURCE('Users-Accounts', UsersAccountsController::class);
        Route::RESOURCE('Customers-Accounts', CustomersAccountsController::class);
    });
});
//الاقسام
Route::GET('Sections', [SectionsController::class, 'index'])->name('Sections');
// الدوائر
Route::GET('Departments', [DepartmentsController::class, 'index'])->name('Departments');
//الكتب الصادرة
Route::GET('OutgoingBooks', [OutgoingBooksController::class, 'index'])->name('OutgoingBooks');
//الكتب الواردة
Route::GET('Incomingbooks', [IncomingbooksController::class, 'index'])->name('Incomingbooks');
