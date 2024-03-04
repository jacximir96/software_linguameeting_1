<?php
Route::prefix('experience')->group(function () {

    Route::prefix('comment')->group(function () {
        Route::get('/{experience}', [\App\Http\Controllers\Experience\CreateCommentController::class, 'configView'])->name('get.experience.comment.create');
        Route::post('/{experience}', [\App\Http\Controllers\Experience\CreateCommentController::class, 'comment'])->name('post.experience.comment.create');
    });


    Route::prefix('file')->group(function () {
        Route::get('/download/{experienceFile}', \App\Http\Controllers\Experience\File\DownloadExperienceFileController::class)->name('get.experience.file.download');
    });


    Route::middleware('experience.tip.can_create_private')->prefix('tip')->group( function () {

        Route::get('create/{experience}/{donor}', [\App\Http\Controllers\Experience\CreateTipController::class, 'configView'])->name('get.experience.tip.create');

        Route::post('create/{experience}/{donor}', [\App\Http\Controllers\Experience\CreateTipController::class, 'update'])->name('post.experience.tip.create');

    });

    Route::prefix('register')->group(function () {

        Route::prefix('payment')->group(function () {
            Route::get('register/{experience}', [\App\Http\Controllers\Experience\RegisterPaymentController::class, 'configView'])->name('get.experience.register.payment');
            Route::post('register/{experience}', [\App\Http\Controllers\Experience\RegisterPaymentController::class, 'register'])->name('post.experience.register.payment');
        });

        Route::prefix('free')->group(function () {
            Route::get('register/{experience}', [\App\Http\Controllers\Experience\RegisterFreeController::class, 'configView'])->name('get.experience.register.free');
            Route::post('register/{experience}', [\App\Http\Controllers\Experience\RegisterFreeController::class, 'register'])->name('post.experience.register.free');
        });

        Route::get('delete/{experience}', \App\Http\Controllers\Experience\DeleteRegisterController::class)->name('get.experience.register.delete');
    });
});
