<?php
Route::prefix('students')->group(function () {

    Route::get('/', \App\Http\Controllers\Admin\Student\IndexController::class)->name('get.admin.student.index');

    Route::match(['get', 'post'], '/search', \App\Http\Controllers\Admin\Student\SearchController::class)->name('post.admin.student.search');

    Route::get('/create', [\App\Http\Controllers\Admin\Student\CreateController::class, 'configView'])->name('get.admin.student.create');
    Route::post('/create', [\App\Http\Controllers\Admin\Student\CreateController::class, 'create'])->name('post.admin.student.create');

    Route::get('/restore/{student}', \App\Http\Controllers\Admin\Student\RestoreController::class)->name('get.admin.student.restore');

    Route::group(['middleware' => 'user_is_student'], function () {

        Route::get('/show/{student}', \App\Http\Controllers\Admin\Student\ShowController::class)->name('get.admin.student.show');
        Route::get('/edit/{student}', [\App\Http\Controllers\Admin\Student\EditController::class, 'configView'])->name('get.admin.student.edit');
        Route::post('/update/{student}', [\App\Http\Controllers\Admin\Student\EditController::class, 'update'])->name('post.admin.student.update');

        Route::get('/delete/{student}', \App\Http\Controllers\Admin\Student\DeleteController::class)->name('get.admin.student.delete');

    });

    Route::prefix('group-actions')->group(function () {
        Route::get( '/download-excel', \App\Http\Controllers\Admin\Student\DownloadListExcelController::class)->name('get.admin.student.excel.download');

        Route::get( '/write-email', [\App\Http\Controllers\Admin\Student\SendEmailController::class, 'configView'])->name('get.admin.student.email.send.config_view');
        Route::post( '/send-email', [\App\Http\Controllers\Admin\Student\SendEmailController::class, 'send'])->name('post.admin.student.email.send.send');
    });

    Route::group(['prefix' => 'enrollment'], function () {

        Route::get('/show/{enrollment}', \App\Http\Controllers\Admin\Student\Enrollment\ShowController::class)->name('get.admin.student.enrollment.show');

    });

    Route::prefix('makeup')->group(function () {

        Route::get('/create/{enrollment}', [\App\Http\Controllers\Admin\Student\Makeup\CreateController::class, 'configView'])->name('get.admin.student.makeup.create');
        Route::post('/create/{enrollment}', [\App\Http\Controllers\Admin\Student\Makeup\CreateController::class, 'create'])->name('post.admin.student.makeup.create');

        Route::get('/edit/{makeup}', [\App\Http\Controllers\Admin\Student\Makeup\EditController::class, 'configView'])->name('get.admin.student.makeup.edit');
        Route::post('/update/{makeup}', [\App\Http\Controllers\Admin\Student\Makeup\EditController::class, 'update'])->name('post.admin.student.makeup.update');

        Route::get('/delete/{makeup}', \App\Http\Controllers\Admin\Student\Makeup\DeleteController::class)->name('get.admin.student.makeup.delete');

    });

    Route::prefix('extra-session')->group(function () {

        Route::get('/create/{enrollment}', \App\Http\Controllers\Admin\Student\ExtraSession\CreateController::class)->name('get.admin.student.extra_session.create');
        Route::post('/create/{enrollment}', \App\Http\Controllers\Admin\Student\ExtraSession\CreateController::class)->name('post.admin.student.extra_session.create');

        Route::get('/delete/{extraSession}', \App\Http\Controllers\Admin\Student\ExtraSession\DeleteController::class)->name('get.admin.student.extra_session.delete');

    });



    Route::prefix('help')->group(function () {

        Route::get('', \App\Http\Controllers\Admin\Student\Help\IndexController::class)
            ->name('get.admin.student.help.index');

        Route::get('/create', [\App\Http\Controllers\Admin\Student\Help\CreateStudentHelpController::class, 'configView'])
            ->name('get.admin.student.help.create');
        Route::post('/create', [\App\Http\Controllers\Admin\Student\Help\CreateStudentHelpController::class, 'create'])
            ->name('post.admin.student.help.create');

        Route::get('/edit/{studentHelp}', [\App\Http\Controllers\Admin\Student\Help\EditStudentHelpController::class, 'configView'])
            ->name('get.admin.student.help.edit');
        Route::post('/edit/{studentHelp}', [\App\Http\Controllers\Admin\Student\Help\EditStudentHelpController::class, 'update'])
            ->name('post.admin.student.help.update');

        Route::get('/delete/{studentHelp}', \App\Http\Controllers\Admin\Student\Help\DeleteStudentHelpController::class)
            ->name('get.admin.student.help.delete');
    });
});
