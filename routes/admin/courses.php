<?php

Route::prefix('course')->group(function () {

    Route::get('/', \App\Http\Controllers\Admin\Course\IndexController::class)->name('get.admin.course.index');

    Route::match(['get', 'post'], '/search', \App\Http\Controllers\Admin\Course\SearchController::class)->name('post.admin.course.search');

    Route::get('/show/{course}', \App\Http\Controllers\Admin\Course\ShowController::class)->name('get.admin.course.show');

    Route::get('/edit-basic/{course}', [\App\Http\Controllers\Admin\Course\EditBasicController::class, 'configView'])
        ->name('get.admin.course.edit.basic');
    Route::post('/update-basic/{course}', [\App\Http\Controllers\Admin\Course\EditBasicController::class, 'update'])
        ->name('post.admin.course.update.basic');

    Route::prefix('coach')->group(function () {

        Route::get('/assign/{course}', [\App\Http\Controllers\Admin\Course\Coach\AssignCoachController::class, 'configView'])
            ->name('get.admin.course.coach.assign');
        Route::post('/assign/{course}', [\App\Http\Controllers\Admin\Course\Coach\AssignCoachController::class, 'assign'])
            ->name('post.admin.course.coach.assign');

        Route::get('/delete/{course}/{coach}', \App\Http\Controllers\Admin\Course\Coach\DeleteCoachController::class)
            ->name('get.admin.course.coach.delete');
    });

    Route::prefix('course-coordinator')->group(function () {

        Route::get('/change/{course}', [\App\Http\Controllers\Admin\Course\CourseCoordinator\ChangeCourseCoordinatorController::class, 'configView'])
            ->name('get.admin.course.course_coordinator.change');
        Route::post('/change/{course}', [\App\Http\Controllers\Admin\Course\CourseCoordinator\ChangeCourseCoordinatorController::class, 'change'])
            ->name('post.admin.course.course_coordinator.change');

        Route::get('/delete/{course}/{instructor}', \App\Http\Controllers\Admin\Course\CourseCoordinator\DeleteCourseCoordinatorController::class)
            ->name('get.admin.course.course_coordinator.delete');
    });

    Route::prefix('documentation')->group(function () {
        Route::get('/send/{course}', [\App\Http\Controllers\Admin\Course\SendDocumentationController::class, 'showView'])
            ->name('get.admin.course.documentation.send.show_log');
        Route::get('/send-confirm/{course}', [\App\Http\Controllers\Admin\Course\SendDocumentationController::class, 'send'])
            ->name('get.admin.course.documentation.send.confirm');
    });

    Route::prefix('group-actions')->group(function () {
        Route::get('/download-excel', \App\Http\Controllers\Admin\Course\DownloadListExcelController::class)->name('get.admin.course.excel.download');

    });

    Route::prefix('log')->group(function () {

        Route::prefix('activity')->group(function () {
            Route::get('/show/{course}', \App\Http\Controllers\Admin\Course\ShowActivityController::class)->name('get.admin.course.log.activity.show');
        });

        Route::prefix('audity')->group(function () {

        });

    });

    Route::prefix('make-up')->group(function () {

        Route::get('/assign/{course}', [\App\Http\Controllers\Admin\Course\AssignMakeUpController::class, 'configView'])
            ->name('get.admin.course.make_up.assign');
        Route::post('/assign/{course}', [\App\Http\Controllers\Admin\Course\AssignMakeUpController::class, 'assign'])
            ->name('post.admin.course.make_up.assign');

        Route::get('/edit-make-up/{course}', [\App\Http\Controllers\Admin\Course\EditMakeUpController::class, 'configView'])
            ->name('get.admin.course.make_up.edit');
        Route::post('/update-make-up/{course}', [\App\Http\Controllers\Admin\Course\EditMakeUpController::class, 'update'])
            ->name('post.admin.course.make_up.update');
    });

    Route::prefix('schedule')->group(function () {

        Route::get('/{course}', \App\Http\Controllers\Admin\Course\Schedule\IndexController::class)
            ->name('get.admin.course.schedule.index');

        Route::get('/browser-weeks/{course}/{page}/{periodKey?}',[\App\Http\Controllers\Admin\Course\Schedule\BrowserController::class, 'browserForWeeks'])
            ->name('get.admin.course.schedule.browser_weeks');

        Route::post('/search/{course}', \App\Http\Controllers\Admin\Course\Schedule\SearchController::class)
            ->name('post.admin.course.schedule.search');

        //flex
        Route::get('/browser/{course}/{startDateWeek}', [\App\Http\Controllers\Admin\Course\Schedule\BrowserController::class, 'browserForFlex'])
            ->name('get.admin.course.schedule.browser');
    });

    Route::prefix('section')->group(function () {


        Route::get('/update/{section}', [\App\Http\Controllers\Admin\Section\EditController::class, 'configView'])
            ->name('get.admin.course.section.edit'); //todo no utlizado


        Route::post('/update/{section}', [\App\Http\Controllers\Admin\Section\EditController::class, 'update'])
            ->name('post.admin.course.section.edit');



        Route::prefix('documentation')->group(function () {
            Route::get('/send/{section}', [\App\Http\Controllers\Admin\Section\SendDocumentationController::class, 'showView'])
                ->name('get.admin.course.section.documentation.send.show_log');

            Route::get('/send-confirm/{section}', [\App\Http\Controllers\Admin\Section\SendDocumentationController::class, 'send'])
                ->name('get.admin.section.documentation.send.confirm');
        });

        Route::prefix('make-up')->group(function () {
            Route::get('/assign/{section}', [\App\Http\Controllers\Admin\Section\AssignMakeUpController::class, 'configView'])
                ->name('get.admin.section.make_up.assign');
            Route::post('/assign/{section}', [\App\Http\Controllers\Admin\Section\AssignMakeUpController::class, 'assign'])
                ->name('post.admin.section.make_up.assign');
        });

        Route::prefix('student')->group(function () {
            Route::get('/{section}', \App\Http\Controllers\Admin\Section\StudentIndexController::class)
                ->name('get.admin.course.section.student.index');
        });
    });

    Route::prefix('session')->group(function () {

        Route::get('/delete/{session}', \App\Http\Controllers\Admin\Course\Session\DeleteSessionController::class)
            ->name('get.admin.course.session.delete');


    });

    Route::prefix('student')->group(function () {
        Route::get('/{course}', \App\Http\Controllers\Admin\Course\StudentIndexController::class)
            ->name('get.admin.course.student.index');
    });

    Route::prefix('user')->group(function () {

        Route::get('/change-access/{course}/{user}', \App\Http\Controllers\Admin\Course\ChangeAccessController::class)
            ->name('get.admin.course.user.change_status');
    });
});
