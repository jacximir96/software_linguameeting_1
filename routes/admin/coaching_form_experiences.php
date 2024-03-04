<?php

Route::prefix('course')->group(function () {


    Route::prefix('coaching-form-experiences')->group(function () {


        Route::prefix('file')->group(function () {
            Route::get('/download-summary/{course}', \App\Http\Controllers\Admin\Course\DownloadExperiencesCourseSummaryController::class)
                ->name('get.admin.course.section.coaching_form_experiences.file.download_summary');
        });


        Route::prefix('config')->group(function () {


            /*step 1 - academic dates*/
            Route::get('/academic-dates/{university}', [\App\Http\Controllers\Admin\Course\CoachingFormExperiences\Wizard\AcademicDatesCreateController::class, 'configView'])
                ->name('get.admin.course.coaching_form_experiences.create.academic_dates');
            Route::post('/academic-dates/{university}', [\App\Http\Controllers\Admin\Course\CoachingFormExperiences\Wizard\AcademicDatesCreateController::class, 'create'])
                ->name('post.admin.course.coaching_form_experiences.create.academic_dates');

            Route::get('/update-academic-dates/{course}', [\App\Http\Controllers\Admin\Course\CoachingFormExperiences\Wizard\AcademicDatesUpdateController::class, 'configView'])
                ->name('get.admin.course.coaching_form_experiences.create.update.academic_dates');
            Route::post('/update-academic-dates/{course}', [\App\Http\Controllers\Admin\Course\CoachingFormExperiences\Wizard\AcademicDatesUpdateController::class, 'update'])
                ->name('post.admin.course.coaching_form_experiences.create.update.academic_dates');

            /*step 2 - section information*/
            Route::get('/section-information/{course}', [\App\Http\Controllers\Admin\Course\CoachingFormExperiences\Wizard\SectionInformationController::class, 'configView'])
                ->name('get.admin.course.coaching_form_experiences.section_information');
            Route::post('/section-information/{course}', [\App\Http\Controllers\Admin\Course\CoachingFormExperiences\Wizard\SectionInformationController::class, 'save'])
                ->name('post.admin.course.coaching_form_experiences.section_information');

            /*step 6 - course summary*/
            Route::get('/course-summary/{course}', \App\Http\Controllers\Admin\Course\CoachingFormExperiences\Wizard\CourseSummaryController::class)
                ->name('get.admin.course.coaching_form_experiences.course_summary');

            /*step 6 - final*/
            /*
            Route::get('/confirmation/{course}', \App\Http\Controllers\Admin\Course\CoachingFormExperiences\Wizard\ConfirmationController::class)
                ->name('get.admin.course.coaching_form_experiences.confirmation');
            */
        });

    });


});
