<?php

Route::prefix('instructor')->group(function () {

    Route::get('/', \App\Http\Controllers\Admin\Instructor\IndexController::class)->name('get.admin.instructor.index');

    Route::get('/show/{instructor}', \App\Http\Controllers\Admin\Instructor\ShowController::class)->name('get.admin.instructor.show');

    Route::match(['get', 'post'], '/search', \App\Http\Controllers\Admin\Instructor\SearchController::class)->name('post.admin.instructor.search');

    Route::get('/create', [\App\Http\Controllers\Admin\Instructor\CreateController::class, 'configView'])->name('get.admin.instructor.create');
    Route::post('/create', [\App\Http\Controllers\Admin\Instructor\CreateController::class, 'create'])->name('post.admin.instructor.create');

    Route::get('/edit/{instructor}', [\App\Http\Controllers\Admin\Instructor\EditController::class, 'configView'])->name('get.admin.instructor.edit');
    Route::post('/edit/{instructor}', [\App\Http\Controllers\Admin\Instructor\EditController::class, 'update'])->name('post.admin.instructor.edit');

    Route::get('/delete/{user}', [\App\Http\Controllers\Admin\Instructor\DeleteController::class, 'configView'])->name('get.admin.instructor.delete');
    Route::post('/delete/{user}', [\App\Http\Controllers\Admin\Instructor\DeleteController::class, 'delete'])->name('post.admin.instructor.delete');

    Route::prefix('group-actions')->group(function () {
        Route::get( '/download-excel', \App\Http\Controllers\Admin\Instructor\DownloadListExcelController::class)->name('get.admin.instructor.excel.download');

        Route::get( '/write-email', [\App\Http\Controllers\Admin\Instructor\SendEmailController::class, 'configView'])->name('get.admin.instructor.email.send.config_view');
        Route::post( '/send-email', [\App\Http\Controllers\Admin\Instructor\SendEmailController::class, 'send'])->name('post.admin.instructor.email.send.send');
    });

    Route::prefix('course')->group(function (){

        Route::get('/assign-multiple/{instructor}', [\App\Http\Controllers\Admin\Course\CourseCoordinator\AssignMultipleCoursesController::class, 'configView'])
            ->name('get.admin.instructor.course.assign_multiple');
        Route::post('/assign-multiple/{instructor}', [\App\Http\Controllers\Admin\Course\CourseCoordinator\AssignMultipleCoursesController::class, 'assign'])
            ->name('post.admin.instructor.course.assign_multiple');

    });

    Route::prefix('teaching-assistant')->group(function () {

        Route::get('/assign-instructor/{assistant}',
            [\App\Http\Controllers\Admin\Instructor\TeachingAssistant\AssignInstructorToAssistantController::class, 'configView'])
            ->name('get.admin.instructor.teaching_assistant.assign_instructor');
        Route::post('/assign-instructor/{assistant}',
            [\App\Http\Controllers\Admin\Instructor\TeachingAssistant\AssignInstructorToAssistantController::class, 'assign'])
            ->name('post.admin.instructor.teaching_assistant.assign_instructor');

        Route::get('/delete-instructor-assigned/{teachingAssistant}',
            \App\Http\Controllers\Admin\Instructor\TeachingAssistant\DeleteInstructorAssignedController::class)
            ->name('get.admin.instructor.teaching_assistant.assign_instructor.delete');
    });



    Route::prefix('help')->group(function () {

        Route::get('', \App\Http\Controllers\Admin\Instructor\Help\IndexController::class)
            ->name('get.admin.instructor.help.index');

        Route::get('/create', [\App\Http\Controllers\Admin\Instructor\Help\CreateHelpController::class, 'configView'])
            ->name('get.admin.instructor.help.create');
        Route::post('/create', [\App\Http\Controllers\Admin\Instructor\Help\CreateHelpController::class, 'create'])
            ->name('post.admin.instructor.help.create');

        Route::get('/edit/{instructorHelp}', [\App\Http\Controllers\Admin\Instructor\Help\EditHelpController::class, 'configView'])
            ->name('get.admin.instructor.help.edit');
        Route::post('/edit/{instructorHelp}', [\App\Http\Controllers\Admin\Instructor\Help\EditHelpController::class, 'update'])
            ->name('post.admin.instructor.help.update');

        Route::get('/delete/{instructorHelp}', \App\Http\Controllers\Admin\Instructor\Help\DeleteHelpController::class)
            ->name('get.admin.instructor.help.delete');
    });

});
