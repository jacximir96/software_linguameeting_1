<?php

Route::prefix('api')->group(function () {

    Route::prefix('sections')->group(function () {

        Route::prefix('options')->group(function () {

            Route::post('from-multiple-course', \App\Http\Controllers\Api\Options\Section\MultipleController::class)
                ->name('post.instructor.api.sections.options.from_multiple_course');
        });
    });

    Route::prefix('students')->group(function () {

        Route::prefix('filter')->group(function () {

            Route::post('by-courses-and-sections', \App\Http\Controllers\Api\Options\Section\PrintStudentsTableFilberTyCourseController::class)
                ->name('post.instructor.api.students.filter.by_course.print_html');
        });

        Route::prefix('accommodation')->group(function () {

            Route::post('update/{enrollment}',\App\Http\Controllers\Student\Api\Accommodation\UpdateAccommodationController::class)
                ->name('post.instructor.api.students.accommodation.update');

            Route::get('delete/{enrollment}',\App\Http\Controllers\Student\Api\Accommodation\DeleteAccommodationController::class)
                ->name('get.instructor.api.students.accommodation.delete');
        });

        Route::prefix('makeup')->group(function () {
            Route::post('assign/{enrollment}',\App\Http\Controllers\Student\Api\Makeup\AssignMakeupController::class)
                ->name('post.instructor.api.students.makeup.assign');
        });
    });
});


Route::prefix('dashboard')->group(function () {
    Route::get('/', \App\Http\Controllers\Instructor\DashboardController::class)->name('get.instructor.dashboard');
});


Route::prefix('course')->group(function () {

    Route::get('', \App\Http\Controllers\Instructor\Course\IndexController::class)->name('get.instructor.course.index');

    Route::get('/show/{course}', \App\Http\Controllers\Instructor\Course\ShowController::class)->name('get.instructor.course.show');

    Route::prefix('active')->group(function () {

        Route::get('/{course_id?}', \App\Http\Controllers\Instructor\Course\Active\IndexController::class)->name('get.instructor.course.active.index');

    });

    Route::prefix('past_course')->group(function () {
        Route::get('/{course_id?}', \App\Http\Controllers\Instructor\Course\PastCourse\IndexController::class)->name('get.instructor.course.past_course.index');
    });



    Route::prefix('gradebook')->group(function () {

        Route::get('', \App\Http\Controllers\Instructor\Course\Gradebook\IndexController::class)->name('get.instructor.course.gradebook.index');

        Route::prefix('file')->group(function () {
            Route::post('generate', \App\Http\Controllers\Instructor\Course\Gradebook\GenerateGradebookFileController::class)->name('post.instructor.course.gradebook.file.generate');
            Route::get('download/{filename?}', \App\Http\Controllers\Instructor\Course\Gradebook\DownloadGradebookFileController::class)->name('get.instructor.course.gradebook.file.download');
        });

        Route::get('show-table/{instructor}', \App\Http\Controllers\Instructor\Course\Gradebook\ShowTableGradebookController::class)->name('get.instructor.course.gradebook.show_table');
    });

    Route::prefix('makeup')->group(function () {
        Route::get('{course}', [\App\Http\Controllers\Instructor\Course\Makeup\AssignMakeUpController::class, 'configView'] )->name('get.instructor.course.makeup.assign');
        Route::post('{course}', [\App\Http\Controllers\Instructor\Course\Makeup\AssignMakeUpController::class, 'assign'])->name('post.instructor.course.makeup.assign');
    });


    Route::prefix('schedule')->group(function () {
        Route::get('/direction', \App\Http\Controllers\Instructor\Course\Schedule\IndexController::class)->name('get.instructor.course.schedule.index');

    });

    Route::prefix('coaches')->group(function () {
        Route::get('', \App\Http\Controllers\Instructor\Course\Coaches\IndexController::class)->name('get.instructor.course.coaches.index');

    });


});

Route::prefix('experiences')->group(function () {

    Route::get('dashboard', \App\Http\Controllers\Instructor\Experiences\DashboardController::class)->name('get.instructor.experiences.dashboard');

    Route::get('list/{status?}', \App\Http\Controllers\Instructor\Experiences\ListController::class)->name('get.instructor.experiences.list');

    Route::get('show/{experience}/{course?}', \App\Http\Controllers\Instructor\Experiences\ShowController::class)->name('get.instructor.experiences.show');

    Route::prefix('search')->group(function () {
        Route::post('', \App\Http\Controllers\Instructor\Experiences\SearchController::class)->name('post.instructor.experiences.search');
    });
});


Route::prefix('asignments')->group(function () {

    Route::get('', \App\Http\Controllers\Instructor\Resources\IndexController::class)->name('get.instructor.resources.index');
});

Route::prefix('canvas')->group(function () {

    Route::get('', \App\Http\Controllers\Instructor\Canvas\IndexController::class)->name('get.instructor.canvas.index');
});



/*cambios para help*/
use App\Http\Controllers\InstructorHelpTypeController;

Route::prefix('help')->group(function () {
    Route::get('', [InstructorHelpTypeController::class, 'index'])->name('get.instructor.help.index');
});


Route::prefix('messaging')->group(function () {

    Route::get('', \App\Http\Controllers\Instructor\Messaging\IndexController::class)->name('get.instructor.messaging.index');

});

Route::prefix('alerts')->group(function () {

    Route::get('edit', [\App\Http\Controllers\Instructor\Alerts\EditAlertsController::class, 'configView'])->name('get.instructor.alerts.edit');

    //Route::post('edit', [\App\Http\Controllers\Coach\Profile\EditProfileController::class, 'update'])->name('post.coach.profile.edit');

});

Route::prefix('admin')->group(function () {
    Route::get('', \App\Http\Controllers\Instructor\Admin\IndexController::class)->name('get.instructor.admin.index');
    Route::get('/delete/{user}', [\App\Http\Controllers\Instructor\Admin\DeleteController::class, 'configView'])->name('get.instructor.admin.delete');
    Route::post('/delete/{user}', [\App\Http\Controllers\Instructor\Admin\DeleteController::class, 'delete'])->name('post.instructor.admin.delete');
    Route::get('/edit/{instructor}', [\App\Http\Controllers\Instructor\Admin\ShowController::class, 'configView'])->name('get.instructor.admin.edit');
    Route::post('/edit/{instructor}', [\App\Http\Controllers\Instructor\Admin\ShowController::class, 'update'])->name('post.instructor.admin.edit');
});

Route::prefix('students')->group(function () {

    Route::get('/show/{enrollment}', \App\Http\Controllers\Instructor\Students\ShowController::class)->name('get.instructor.students.show');

    Route::prefix('enrollment')->group(function () {

        Route::post('change/{enrollment}', \App\Http\Controllers\Instructor\Students\ChangeSectionController::class)
            ->name('post.instructor.students.enrollment.section.change');

        Route::get('/delete/{enrollment}', \App\Http\Controllers\Instructor\Students\DeleteController::class)->name('get.instructor.students.enrollment.section.change');

        Route::prefix('session')->group(function () {

            Route::prefix('feedback')->group(function () {

                Route::get('edit/{studentReview}', [\App\Http\Controllers\Instructor\Students\UpdateStudentReviewController::class, 'configView'])
                    ->name('get.instructor.students.enrollment.session.feedback.show_form');

                Route::post('update/{studentReview}', [\App\Http\Controllers\Instructor\Students\UpdateStudentReviewController::class, 'update'])
                    ->name('post.instructor.students.enrollment.session.feedback.show_form');
            });
        });
    });
});

Route::prefix('coaching_form')->group(function () {

    Route::get('/zero-step', [\App\Http\Controllers\Admin\Course\CoachingForm\Wizard\StartController::class, 'configView'])
                ->name('get.instructor.coaching_form.zero_step');

});


