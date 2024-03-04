<?php

Route::prefix('evaluation-manager')->group(function () {

    Route::get('/show/{coach}',\App\Http\Controllers\Coach\Feedback\Manager\ShowEvaluationManagerController::class)
        ->name('get.common.coaches.evaluation_manager.show');

    Route::prefix('file')->group(function () {

        Route::get('download/{file}', \App\Http\Controllers\Coach\Feedback\Manager\DownloadFileController::class)
            ->name('get.common.coaches.evaluation_manager.file.download');
    });
});
