<?php

Route::prefix('conversation-guide')->group(function () {

    Route::prefix('conversation-guide-chapter')->group(function () {

        Route::get('/download-file/{file}', \App\Http\Controllers\ConversationGuide\Guide\DownloadGuideChapterController::class)
            ->name('get.common.conversation_guide.chapter.file.download');
    });
});
