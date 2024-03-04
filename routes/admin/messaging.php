<?php

Route::prefix('messaging')->group(function () {

    Route::get('inbox', \App\Http\Controllers\Admin\Messaging\IndexInboxController::class)->name('get.admin.messaging.inbox.index');
    Route::get('sent', \App\Http\Controllers\Admin\Messaging\IndexSentController::class)->name('get.admin.messaging.sent.index');

    Route::get('/create', [\App\Http\Controllers\Admin\Messaging\Thread\CreateThreadController::class, 'configView'])
        ->name('get.admin.messaging.create');
    Route::post('/create', [\App\Http\Controllers\Admin\Messaging\Thread\CreateThreadController::class, 'create'])
        ->name('post.admin.messaging.create');

    Route::get('/delete/{thread}', \App\Http\Controllers\Admin\Messaging\Thread\DeleteThreadController::class)
        ->name('get.admin.messaging.delete');
});
