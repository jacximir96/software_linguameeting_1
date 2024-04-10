<?php

Route::prefix('conversation-guide')->group(function () {

    Route::prefix('conversation-guide-chapter')->group(function () {

        Route::get('/download-file/{file}', \App\Http\Controllers\ConversationGuide\Guide\DownloadGuideChapterController::class)
            ->name('get.common.conversation_guide.chapter.file.download');
        
        Route::get('/downloadChapter-file/{chapter?}', [\App\Http\Controllers\ConversationGuide\Guide\DownloadGuideChapterController::class, 'downloadChapter'])
            ->name('get.common.conversation_guide.chapter.file.downloadChapter');

        Route::get('/showChapter-file/{chapter?}', [\App\Http\Controllers\ConversationGuide\Guide\DownloadGuideChapterController::class, 'showChapter'])
            ->name('get.common.conversation_guide.chapter.file.showChapter');

        Route::get('/downloadAllChapter-file/{chapter?}', [\App\Http\Controllers\ConversationGuide\Guide\DownloadGuideChapterController::class, 'downloadAllChapter'])
            ->name('get.common.conversation_guide.chapter.file.downloadAllChapter');
    });
});
