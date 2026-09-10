<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BabyRecordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\VaccinationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('baby_records', BabyRecordController::class)->except(['show']);
    // カレンダー表示
    Route::get('/baby_records/calendar', [BabyRecordController::class, 'calendar'])->name('baby_records.calendar');

    // 日別一覧表示
    Route::get('/baby_records/daily', [BabyRecordController::class, 'daily'])->name('baby_records.daily');

    // 子供情報のCRUDルート（マイページ）
    Route::resource('children', ChildController::class)->except(['show']);
    // 予防接種記録のCRUDルート
    Route::resource('vaccinations', VaccinationController::class)->except(['show']);
});

// 管理者専用ルート（adminミドルウェアで保護）
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
   // ユーザー管理
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::post('/users', [App\Http\Controllers\AdminController::class, 'storeUser'])->name('storeUser');
    Route::post('/users/{user}/toggle-admin', [App\Http\Controllers\AdminController::class, 'toggleAdmin'])->name('toggleAdmin');
    // 管理者ダッシュボード
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('index');
    // ソフトデリート管理
    Route::get('/trashed', [App\Http\Controllers\AdminController::class, 'trashed'])->name('trashed');
    Route::post('/restore/{id}', [App\Http\Controllers\AdminController::class, 'restore'])->name('restore');
    Route::delete('/force-delete/{id}', [App\Http\Controllers\AdminController::class, 'forceDelete'])->name('forceDelete');
    // CSVエクスポート
    Route::get('/export', [App\Http\Controllers\AdminController::class, 'export'])->name('export');
});
require __DIR__.'/auth.php';