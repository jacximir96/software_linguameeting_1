<?php

Route::prefix('conversation-guide')->group(function () {
    Route::get('/', \App\Http\Controllers\Admin\Config\ConversationGuide\Guide\IndexGuideController::class)->name('get.admin.config.conversation_guide.index');

    Route::get('/show/{guide}', \App\Http\Controllers\Admin\Config\ConversationGuide\Guide\ShowGuideController::class)->name('get.admin.config.conversation_guide.show');

    Route::get('/edit/{guide}', [\App\Http\Controllers\Admin\Config\ConversationGuide\Guide\EditGuideController::class, 'configView'])
        ->name('get.admin.config.conversation_guide.edit');
    Route::post('/update/{guide}', [\App\Http\Controllers\Admin\Config\ConversationGuide\Guide\EditGuideController::class, 'update'])
        ->name('post.admin.config.conversation_guide.update');


    Route::prefix('files')->group(function () {

        Route::get('/create/{guide}', [\App\Http\Controllers\Admin\Config\ConversationGuide\File\CreateFileController::class, 'configView'])
            ->name('get.admin.config.conversation_guide.file.create');
        Route::post('/create/{guide}', [\App\Http\Controllers\Admin\Config\ConversationGuide\File\CreateFileController::class, 'create'])
            ->name('post.admin.config.conversation_guide.file.create');

        Route::get('/edit/{file}', [\App\Http\Controllers\Admin\Config\ConversationGuide\File\EditFileController::class, 'configView'])
            ->name('get.admin.config.conversation_guide.file.edit');
        Route::post('/update/{file}', [\App\Http\Controllers\Admin\Config\ConversationGuide\File\EditFileController::class, 'update'])
            ->name('post.admin.config.conversation_guide.file.update');

        Route::get('/delete/{file}', \App\Http\Controllers\Admin\Config\ConversationGuide\File\DeleteFileController::class)
            ->name('get.admin.config.conversation_guide.file.delete');

        Route::get('/download/{file}', \App\Http\Controllers\Admin\Config\ConversationGuide\File\DownloadController::class)
            ->name('get.admin.config.conversation_guide.file.download');

    });

    Route::prefix('conversation-guide-chapter')->group(function () {


        Route::get('/create/{guide}', [\App\Http\Controllers\Admin\Config\ConversationGuide\Chapter\CreateChapterController::class, 'configView'])
            ->name('get.admin.config.conversation_guide.chapter.create');
        Route::post('/create/{guide}', [\App\Http\Controllers\Admin\Config\ConversationGuide\Chapter\CreateChapterController::class, 'create'])
            ->name('post.admin.config.conversation_guide.chapter.create');


        Route::get('/edit/{chapter}', [\App\Http\Controllers\Admin\Config\ConversationGuide\Chapter\EditChapterController::class, 'configView'])
            ->name('get.admin.config.conversation_guide.chapter.edit');
        Route::post('/update/{chapter}', [\App\Http\Controllers\Admin\Config\ConversationGuide\Chapter\EditChapterController::class, 'update'])
            ->name('post.admin.config.conversation_guide.chapter.update');

        Route::get('/delete/{chapter}', \App\Http\Controllers\Admin\Config\ConversationGuide\Chapter\DeleteChapterController::class)
            ->name('get.admin.config.conversation_guide.delete');
    });


    Route::prefix('template')->group(function () {

        Route::get('/', \App\Http\Controllers\Admin\Config\ConversationGuide\Template\IndexTemplateController::class)
            ->name('get.admin.config.conversation_guide.template.index');

        Route::get('/create', [\App\Http\Controllers\Admin\Config\ConversationGuide\Template\CreateTemplateController::class, 'configView'])
            ->name('get.admin.config.conversation_guide.template.create');
        Route::post('/create', [\App\Http\Controllers\Admin\Config\ConversationGuide\Template\CreateTemplateController::class, 'create'])
            ->name('post.admin.config.conversation_guide.template.create');

        Route::get('/edit/{template}', [\App\Http\Controllers\Admin\Config\ConversationGuide\Template\EditTemplateController::class, 'configView'])
            ->name('get.admin.config.conversation_guide.template.edit');
        Route::post('/update/{template}', [\App\Http\Controllers\Admin\Config\ConversationGuide\Template\EditTemplateController::class, 'update'])
            ->name('post.admin.config.conversation_guide.template.update');

        Route::get('/delete/{template}', \App\Http\Controllers\Admin\Config\ConversationGuide\Template\DeleteTemplateController::class)
            ->name('get.admin.config.conversation_guide.template.delete');

        Route::get('/download-file/{file}', \App\Http\Controllers\Admin\Config\ConversationGuide\Template\DownloadTemplateController::class)
            ->name('get.admin.config.conversation_guide.template.file.download');
    });
});
