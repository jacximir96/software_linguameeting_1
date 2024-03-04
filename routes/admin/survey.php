<?php


Route::prefix('survey')->group(function () {

    Route::get('/', \App\Http\Controllers\Admin\Survey\IndexSurveyController::class)->name('get.admin.survey.index');

    Route::get('/show/{survey}', \App\Http\Controllers\Admin\Survey\ShowSurveyController::class)->name('get.admin.survey.show');

    Route::get('/create/{type}/{id}', [\App\Http\Controllers\Admin\Survey\CreateSurveyController::class, 'configView'])
        ->name('get.admin.survey.create');
    Route::post('/create/{type}/{id}', [\App\Http\Controllers\Admin\Survey\CreateSurveyController::class, 'create'])
        ->name('post.admin.survey.create');

    Route::get('/edit/{survey}', [\App\Http\Controllers\Admin\Survey\EditSurveyController::class, 'configView'])
        ->name('get.admin.survey.edit');
    Route::post('/update/{survey}', [\App\Http\Controllers\Admin\Survey\EditSurveyController::class, 'update'])
        ->name('post.admin.survey.update');

    Route::get('/delete/{survey}', \App\Http\Controllers\Admin\Survey\DeleteSurveyController::class)
        ->name('get.admin.survey.delete');
});

