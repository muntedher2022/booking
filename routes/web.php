<?php

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Backup\BackupController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Sections\SectionsController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\Tracking\TrackingController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Emaillists\EmaillistsController;
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
//الكتب الواردة
Route::GET('Incomingbooks', [IncomingbooksController::class, 'index'])->name('Incomingbooks');


// البريد الالكتروني للاقسام
Route::GET('Emaillists', [EmaillistsController::class, 'index'])->name('Emaillists');
// التتبع
Route::GET('Tracking', [TrackingController::class, 'index'])->name('Tracking');
// تحديث مسارات التقارير
Route::GET('Reports', [ReportController::class, 'index'])->name('Reports');
Route::POST('Reports/generate', [ReportController::class, 'generateReport'])->name('Reports.generate');
// مسار النسخ الاحتياطي
Route::GET('Backup', [BackupController::class, 'index'])->name('Backup')->middleware('role:OWNER');

/* //مسار جهاز المسح الضوئي لبرنامج Dynamsoft
Route::get('/scan', function () {
    return view('scan');
});
 */
// مقترحات الكلمات المفتاحية
Route::get('/keywords/suggestions', [IncomingbooksController::class, 'getKeywordSuggestions']);



//مسار جهاز المسح الضوئي لبرنامج NAPS2
Route::get('/latest-scan', function () {
    $sourceDir = public_path('storage/uploads');
    $publicDir = public_path('storage/uploads');

    if (!File::exists($sourceDir)) {
        File::makeDirectory($sourceDir, 0755, true);
        return response()->json(['message' => 'مجلد المسح غير موجود.'], 404);
    }

    $files = File::files($sourceDir);

    if (empty($files)) {
        return response()->json(['message' => 'لا توجد ملفات مسح.'], 404);
    }

    // جلب الملفات التي تم إنشاؤها أو تعديلها خلال آخر 60 ثانية
    $recentFiles = collect($files)->filter(function ($file) {
        return now()->diffInSeconds(Carbon::createFromTimestamp($file->getMTime())) <= 60;
    });

    if ($recentFiles->isEmpty()) {
        return response()->json(['message' => 'لم يتم العثور على ملف جديد مؤخراً.'], 404);
    }

    // جلب أحدث ملف
    $latestFile = $recentFiles->sortByDesc(fn($file) => $file->getMTime())->first();
    $originalFileName = $latestFile->getFilename();

    return response()->json([
        'name' => $originalFileName,
        'url' => Storage::url('uploads/' . $originalFileName)
    ]);
});

// إعدادات النظام
Route::middleware(['auth'])->prefix('settings')->group(function () {
    Route::get('/', [SettingsController::class, 'index'])->name('settings');
});



