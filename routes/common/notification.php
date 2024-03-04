<?php
Route::prefix('notification')->group(function () {

    Route::get('', \App\Http\Controllers\Notification\IndexController::class)->name('get.notification.index');

    Route::match(['get', 'post'], '/search', \App\Http\Controllers\Notification\SearchController::class)->name('post.notification.search');

    Route::get('mark-read/{notificationRecipient}', \App\Http\Controllers\Notification\MarkReadController::class)->name('get.notification.mark_read');
});
