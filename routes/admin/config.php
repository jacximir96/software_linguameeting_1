<?php

Route::prefix('config')->group(function () {

    Route::prefix('accommodation')->group(function () {

        Route::prefix('options')->group(function () {

            Route::get('', \App\Http\Controllers\Admin\Config\AccommodationType\IndexController::class)
                ->name('get.admin.config.accommodation_type.index');

            Route::get('/create', [\App\Http\Controllers\Admin\Config\AccommodationType\CreateController::class, 'configView'])
                ->name('get.admin.config.accommodation_type.create');
            Route::post('/create', [\App\Http\Controllers\Admin\Config\AccommodationType\CreateController::class, 'create'])
                ->name('post.admin.config.accommodation_type.create');

            Route::get('/edit/{accommodationType}', [\App\Http\Controllers\Admin\Config\AccommodationType\EditController::class, 'configView'])
                ->name('get.admin.config.accommodation_type.edit');
            Route::post('/edit/{accommodationType}', [\App\Http\Controllers\Admin\Config\AccommodationType\EditController::class, 'update'])
                ->name('post.admin.config.accommodation_type.update');

            Route::get('/delete/{accommodationType}', \App\Http\Controllers\Admin\Config\AccommodationType\DeleteController::class)
                ->name('get.admin.config.accommodation_type.delete');
        });
    });

    Route::prefix('experience')->group(function () {

        Route::prefix('levels')->group(function () {

            Route::get('', App\Http\Controllers\Admin\Config\ExperienceLevel\IndexController::class)
                ->name('get.admin.config.experience_level.index');

            Route::get('/create', [\App\Http\Controllers\Admin\Config\ExperienceLevel\CreateController::class, 'configView'])
                ->name('get.admin.config.experience_level.create');
            Route::post('/create', [\App\Http\Controllers\Admin\Config\ExperienceLevel\CreateController::class, 'create'])
                ->name('post.admin.config.experience_level.create');

            Route::get('/edit/{level}', [\App\Http\Controllers\Admin\Config\ExperienceLevel\EditController::class, 'configView'])
                ->name('get.admin.config.experience_level.edit');
            Route::post('/edit/{level}', [\App\Http\Controllers\Admin\Config\ExperienceLevel\EditController::class, 'update'])
                ->name('post.admin.config.experience_level.update');

            Route::get('/delete/{level}', \App\Http\Controllers\Admin\Config\ExperienceLevel\DeleteController::class)
                ->name('get.admin.config.experience_level.delete');
        });
    });

    Route::prefix('conversation-package')->group(function () {

        Route::get('', \App\Http\Controllers\Admin\Config\ConversationPackage\IndexController::class)
            ->name('get.admin.config.conversation_package.index');

        Route::get('create', [\App\Http\Controllers\Admin\Config\ConversationPackage\CreateController::class, 'configView'])
            ->name('get.admin.config.conversation_package.create');
        Route::post('create', [\App\Http\Controllers\Admin\Config\ConversationPackage\CreateController::class, 'create'])
            ->name('post.admin.config.conversation_package.create');

        Route::get('/edit/{conversationPackage}', [\App\Http\Controllers\Admin\Config\ConversationPackage\EditController::class, 'configView'])
            ->name('get.admin.config.conversation_package.edit');
        Route::post('/edit/{conversationPackage}', [\App\Http\Controllers\Admin\Config\ConversationPackage\EditController::class, 'update'])
            ->name('post.admin.config.conversation_package.update');

        Route::get('/delete/{conversationPackage}', \App\Http\Controllers\Admin\Config\ConversationPackage\DeleteController::class)
            ->name('get.admin.config.conversation_package.delete');
    });



    Route::prefix('jira-chat')->group(function () {
        Route::get('edit', [\App\Http\Controllers\Admin\Config\Jira\EditChatController::class, 'configView'])
            ->name('get.admin.config.jira.chat.edit');
        Route::post('update', [\App\Http\Controllers\Admin\Config\Jira\EditChatController::class, 'update'])
            ->name('post.admin.config.jira.chat.edit');
    });

    Route::prefix('language')->group(function () {

        Route::get('/', \App\Http\Controllers\Admin\Config\Language\IndexLanguageController::class)->name('get.admin.config.language.index');

        Route::get('create', [\App\Http\Controllers\Admin\Config\Language\CreateLanguageController::class, 'configView'])->name('get.admin.config.language.create');
        Route::post('create', [\App\Http\Controllers\Admin\Config\Language\CreateLanguageController::class, 'create'])->name('post.admin.config.language.create');

        Route::get('edit/{language}', [ \App\Http\Controllers\Admin\Config\Language\EditLanguageController::class, 'configView'])->name('get.admin.config.language.edit');
        Route::post('update/{language}', [ \App\Http\Controllers\Admin\Config\Language\EditLanguageController::class, 'update'])->name('post.admin.config.language.update');

        Route::get('delete/{language}', \App\Http\Controllers\Admin\Config\Language\DeleteLanguageController::class)->name('get.admin.config.language.delete');
    });

    Route::prefix('user')->group(function () {
        Route::get('edit', [\App\Http\Controllers\Admin\Config\User\EditUserController::class, 'configView'])
            ->name('get.admin.config.user.edit');
        Route::post('update', [\App\Http\Controllers\Admin\Config\User\EditUserController::class, 'update'])
            ->name('post.admin.config.user.edit');
    });
});
