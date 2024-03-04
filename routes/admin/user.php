<?php
Route::prefix('user')->group(function () {

    Route::get('remove-lock/{user}', \App\Http\Controllers\Admin\User\RemoveLockController::class)->name('get.user.lock.remove');

    Route::get('/restore/{userId}', \App\Http\Controllers\Admin\User\RestoreController::class)->name('get.admin.user.restore');

    Route::prefix('activity')->group(function () {
        Route::get('/{user}', \App\Http\Controllers\Admin\User\IndexActivityController::class)->name('get.user.activity.index');
    });
});
