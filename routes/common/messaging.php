<?php

Route::prefix('messaging')->middleware('user_is_participant_in_thread')->group(function () {

    Route::prefix('thread')->group(function () {

        Route::get('show/{thread}', App\Http\Controllers\Messaging\Thread\ShowController::class)
            ->name('get.common.messaging.thread.show');

        Route::post('/reply/{thread}', \App\Http\Controllers\Messaging\Thread\ReplyThreadController::class)
            ->name('post.common.messaging.thread.reply');
    });

    Route::prefix('message')->group(function () {

        Route::get('/delete/{message}', \App\Http\Controllers\Messaging\Message\DeleteMessageController::class)->name('get.common.messaging.message.delete');
    });

    Route::prefix('file')->group(function () {

        Route::get('/download/{threadFile}', \App\Http\Controllers\Messaging\File\DownloadThreadFileController::class)->name('get.common.messaging.file.download');
    });
});
