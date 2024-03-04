<?php

Route::prefix('assignment')->middleware(['user_can_handle_coaching_form',])->group(function () {


    Route::get('/edit-week-assignment/{section}/{coachingWeek}', [\App\Http\Controllers\Course\Assignment\EditWeekAssignmentController::class, 'configView'])
        ->name('get.common.course.assignment.week.edit');
    Route::post('/edit-week-assignment/{section}/{coachingWeek}', [\App\Http\Controllers\Course\Assignment\EditWeekAssignmentController::class, 'update'])
        ->name('post.common.course.assignment.week.update');


    Route::get('/edit-flex-assignment/{section}/{sessionOrder}', [\App\Http\Controllers\Course\Assignment\EditFlexAssignmentController::class, 'configView'])
        ->name('get.common.course.assignment.flex.edit');
    Route::post('/edit-flex-assignment/{section}/{sessionOrder}', [\App\Http\Controllers\Course\Assignment\EditFlexAssignmentController::class, 'update'])
        ->name('post.common.course.assignment.flex.update');

    Route::prefix('api')->group(function () {

        Route::get('/download/{assignmentFile}', \App\Http\Controllers\Course\Assignment\DownloadAssignmentFileController::class)
            ->name('get.common.course.assignment.file.download');

        Route::get('/delete/{assignmentFile}', \App\Http\Controllers\Course\Assignment\DeleteAssignmentFileController::class)
            ->name('get.common.course.assignment.file.delete');

    });


    Route::prefix('api')->group(function () {

        Route::prefix('guide')->group(function () {

            Route::post('/update-week-one-on-one/{section}/{coachingWeek}', \App\Http\Controllers\Course\Assignment\UpdateGuideForWeekOneOnOneController::class)
                ->name('post.common.course.assignment.api.guide.update.week.one_on_one');

            Route::post('/update-week-small-group/{coachingWeek}', \App\Http\Controllers\Course\Assignment\UpdateGuideForWeekSmallGroupController::class)
                ->name('post.common.course.assignment.api.guide.update.week.small');

            Route::post('/update-flex-one-on-one/{section}/{sessionNumber}', \App\Http\Controllers\Course\Assignment\UpdateGuideForFlexOneOnOneController::class)
                ->name('post.common.course.assignment.api.guide.update.flex.one_on_one');

            Route::post('/update-flex-small-group/{section}/{coachingWeek}', \App\Http\Controllers\Course\Assignment\UpdateGuideForFlexSmallGroupController::class)
                ->name('post.common.course.assignment.api.guide.update.flex.small');
        });
    });
});


Route::prefix('instructor')->middleware(['user_can_handle_coaching_form',])->group(function () {



    Route::prefix('course-coordinator')->group(function () {

        Route::get('/assign-to-course/{course}', [\App\Http\Controllers\Course\Instructor\CreateCourseCoordinatorController::class, 'configView'])
            ->name('get.common.course.course_coordinator.create');
        Route::post('/assign-to-course/{course}', [\App\Http\Controllers\Course\Instructor\CreateCourseCoordinatorController::class, 'create'])
            ->name('post.common.course.course_coordinator.create');
    });

    Route::prefix('simple')->group(function () {

        Route::get('/create-simple/{university}/{language}', [\App\Http\Controllers\Course\Instructor\CreateSimpleController::class, 'configView'])
            ->name('get.common.course.instructor.simple.create');
        Route::post('/create-simple/{university}/{language}', [\App\Http\Controllers\Course\Instructor\CreateSimpleController::class, 'create'])
            ->name('post.common.course.instructor.simple.create');
    });

    Route::prefix('teaching-assistant')->group(function () {

        Route::prefix('section')->group(function () {

            Route::get('/create/{section}', [\App\Http\Controllers\Course\Instructor\AssignTeachingAssistantToSectionController::class, 'configView'])
                ->name('get.common.course.instructor.teching_assistant.section.create');
            Route::post('/create/{section}', [\App\Http\Controllers\Course\Instructor\AssignTeachingAssistantToSectionController::class, 'create'])
                ->name('post.common.course.instructor.teching_assistant.section.create');

            Route::post('/delete/{sectionTeachingAssistant}', \App\Http\Controllers\Api\Section\DeleteSectionTeachingAssistantController::class)
                ->name('get.common.course.instructor.teching_assistant.section.delete');

        });
    });

});

Route::prefix('section')->middleware(['user_can_handle_coaching_form',])->group(function () {


    Route::prefix('api')->group(function () {
        //botón save section en CF
        Route::post('/update/{section}', \App\Http\Controllers\Api\Section\UpdateFromCoachingFormController::class)
            ->name('post.common.course.section.api.update');

        Route::get('/load-section/{section}', \App\Http\Controllers\Api\Section\LoadItemSectionCoachingFormController::class)
            ->name('get.common.course.section.api.load_section');
    });

    Route::get('/create/{course}', [\App\Http\Controllers\Course\Section\CreateController::class, 'configView'])
        ->name('get.common.course.section.create');
    Route::post('/create/{course}', [\App\Http\Controllers\Course\Section\CreateController::class, 'create'])
        ->name('post.common.course.section.create');

    Route::get('/delete/{section}', \App\Http\Controllers\Course\Section\DeleteController::class)
        ->name('get.common.course.section.delete');

    Route::prefix('file')->group(function () {
        Route::get('/download-instructions/{section}', \App\Http\Controllers\Course\Section\DownloadInstructionsController::class)
            ->name('get.common.course.section.file.instructions.download');
    });

});
