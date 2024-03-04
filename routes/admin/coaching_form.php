<?php

use App\Http\Controllers\Instructor\Course\Active\ActiveCourseController;

Route::prefix('course')->group(function () {


    Route::prefix('coaching-form')->group(function () {

        Route::prefix('file')->group(function () {
            Route::get('/download-summary/{course}', \App\Http\Controllers\Admin\Course\DownloadCourseSummaryController::class)
                ->name('get.admin.course.section.coaching_form.file.download_summary');
        });

        Route::prefix('config')->group(function () {

            Route::get('/zero-step', [\App\Http\Controllers\Admin\Course\CoachingForm\Wizard\StartController::class, 'configView'])
                ->name('get.admin.course.coaching_form.create.zero_step');
            Route::post('/zero-step', [\App\Http\Controllers\Admin\Course\CoachingForm\Wizard\StartController::class, 'create'])
                ->name('post.admin.course.coaching_form.create.zero_step');


            /*step 1 - academic dates*/
            Route::get('/academic-dates', [\App\Http\Controllers\Admin\Course\CoachingForm\Wizard\AcademicDatesCreateController::class, 'configView'])
                ->name('get.admin.course.coaching_form.create.academic_dates');
            Route::post('/academic-dates', [\App\Http\Controllers\Admin\Course\CoachingForm\Wizard\AcademicDatesCreateController::class, 'save'])
                ->name('post.admin.course.coaching_form.create.academic_dates');

            Route::get('/update-academic-dates/{course}', [\App\Http\Controllers\Admin\Course\CoachingForm\Wizard\AcademicDateUpdateController::class, 'configView'])
                ->name('get.admin.course.coaching_form.create.update.academic_dates');
            Route::post('/update-academic-dates/{course}', [\App\Http\Controllers\Admin\Course\CoachingForm\Wizard\AcademicDateUpdateController::class, 'save'])
                ->name('post.admin.course.coaching_form.create.update.academic_dates');

            /*step 2 - course information*/
            Route::get('/course-information', [\App\Http\Controllers\Admin\Course\CoachingForm\Wizard\CourseInformationCreateController::class, 'configView'])
                ->name('get.admin.course.coaching_form.create.course_information');
            Route::post('/course-information', [\App\Http\Controllers\Admin\Course\CoachingForm\Wizard\CourseInformationCreateController::class, 'save'])
                ->name('post.admin.course.coaching_form.create.course_information');

            Route::get('/update-course-information/{course}', [\App\Http\Controllers\Admin\Course\CoachingForm\Wizard\CourseInformationUpdateController::class, 'configView'])
                ->name('get.admin.course.coaching_form.update.course_information');
            Route::post('/update-course-information/{course}', [\App\Http\Controllers\Admin\Course\CoachingForm\Wizard\CourseInformationUpdateController::class, 'save'])
                ->name('post.admin.course.coaching_form.update.course_information');

            Route::get('/duplicate-course-coaching-form/{course}', [\App\Http\Controllers\Admin\Course\CoachingForm\Wizard\CourseDateDuplicateController::class, 'configView'])
                ->name('get.admin.course.coaching_form.duplicate.course_information');
            Route::post('/duplicate-course-coaching-form/{course}', [\App\Http\Controllers\Admin\Course\CoachingForm\Wizard\CourseDateDuplicateController::class, 'save'])
                ->name('post.admin.course.coaching_form.duplicate.course_information');


            /*step 3 - coaching weeks*/
            Route::get('/coaching-weeks/{course}', [\App\Http\Controllers\Admin\Course\CoachingForm\Wizard\CoachingWeeksController::class, 'configView'])
                ->name('get.admin.course.coaching_form.coaching_weeks');
            Route::post('/coaching-weeks/{course}', [\App\Http\Controllers\Admin\Course\CoachingForm\Wizard\CoachingWeeksController::class, 'save'])
                ->name('post.admin.course.coaching_form.coaching_weeks');

            /*step 4 - section information*/
            Route::get('/section-information/{course}', [\App\Http\Controllers\Admin\Course\CoachingForm\Wizard\SectionInformationController::class, 'configView'])
                ->name('get.admin.course.coaching_form.section_information');
            Route::post('/section-information/{course}', [\App\Http\Controllers\Admin\Course\CoachingForm\Wizard\SectionInformationController::class, 'save'])
                ->name('post.admin.course.coaching_form.section_information');

            /*step 5 - course assignment*/
            //show view
            Route::get('/course-assignment/{course}', [\App\Http\Controllers\Admin\Course\CoachingForm\Wizard\CourseAssignmentController::class, 'configView'])
                ->name('get.admin.course.coaching_form.course_assignment'); //valid

            //save and next week-small group | ok
            Route::post('/update-week-small-group-assignment/{course}', [\App\Http\Controllers\Admin\Course\CoachingForm\Wizard\CourseAssignmentController::class, 'updateWeekSmallGroup'])
                ->name('post.admin.course.coaching_form.course_assignment.update.week.small_group'); //valid

            //save and next week-one-on-one | ok
            Route::post('/update-week-one-on-one-assignment/{course}', [\App\Http\Controllers\Admin\Course\CoachingForm\Wizard\CourseAssignmentController::class, 'updateWeekOneOnOne'])
                ->name('post.admin.course.coaching_form.course_assignment.update.week.one_on_one'); //valid

            //save and next flex-small group | ok
            Route::post('/update-flex-small-group-assignment/{course}', [\App\Http\Controllers\Admin\Course\CoachingForm\Wizard\CourseAssignmentController::class, 'updateFlexSmallGroup'])
                ->name('post.admin.course.coaching_form.course_assignment.update.flex.small_group'); //valid

            //save and next flex-one-on-one | ok
            Route::post('/update-flex-one-on-one-assignment/{course}', [\App\Http\Controllers\Admin\Course\CoachingForm\Wizard\CourseAssignmentController::class, 'updateFlexOneOnOne'])
                ->name('post.admin.course.coaching_form.course_assignment.update.flex.one_on_one'); //valid

            //save and next flex-one-on-one for all
            Route::post('/update-one-on-one-assignment-for-all', [\App\Http\Controllers\Admin\Course\CoachingForm\Wizard\CourseAssignmentController::class, 'updateOneOnOneForAll'])
                ->name('post.admin.course.coaching_form.course_assignment.update.flex.one_on_one.for_all'); //valid

            /*step 6 - course summary*/
            Route::get('/course-summary/{course}', \App\Http\Controllers\Admin\Course\CoachingForm\Wizard\CourseSummaryController::class)
                ->name('get.admin.course.coaching_form.course_summary');

            /*step 6 - final*/
            Route::get('/confirmation/{course}', \App\Http\Controllers\Admin\Course\CoachingForm\Wizard\ConfirmationController::class)
                ->name('get.admin.course.coaching_form.confirmation');
            Route::post('/close-course/{course}', [ActiveCourseController::class, 'closeCourse'])
                ->name('post.admin.course.coaching_form.close.course');
        });

    });


});
