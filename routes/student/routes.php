<?php

Route::prefix('api')->group(function () {

    Route::prefix('session')->group(function () {

        Route::prefix('get')->group(function () {

            Route::get('flex/{enrollment}/{sessionOrder}/{calendarPage?}', \App\Http\Controllers\Student\Session\Api\SearchSessionForFlexCourseController::class)
                ->name('get.student.api.session.get.flex');

            Route::get('coaching-week/{enrollment}/{sessionOrder}/{calendarPage?}', \App\Http\Controllers\Student\Session\Api\SearchSessionForWeekCourseController::class)
                ->name('get.student.api.session.get.coaching_week');
        });
    });
});

Route::prefix('calendar')->group(function () {

    Route::get('/show', \App\Http\Controllers\Student\Calendar\ShowController::class)
        ->name('get.student.calendar.show');

    Route::prefix('google')->group(function () {
        Route::get('/generate', [\App\Http\Controllers\Student\Calendar\Google\GenerateController::class, 'configView'])->name('get.student.calendar.google.generate');
        Route::post('/generate', [\App\Http\Controllers\Student\Calendar\Google\GenerateController::class, 'generate'])->name('post.student.calendar.google.generate');
    });
});


Route::prefix('dashboard')->group(function () {
    Route::get('/', \App\Http\Controllers\Student\DashboardController::class)->name('get.student.dashboard');
});

Route::prefix('enrollment')->group(function () {

    Route::prefix('additional')->group(function () {
        Route::get('create', [\App\Http\Controllers\Student\Enrollment\CreateAdditionalController::class, 'configView'])->name('get.student.enrollment.additional.code');
        Route::post('create', [\App\Http\Controllers\Student\Enrollment\CreateAdditionalController::class, 'checkCode'])->name('post.student.enrollment.additional.code');

        Route::get('paid/{sectionCode}', [\App\Http\Controllers\Student\Enrollment\CreatePaidAdditionalController::class, 'configView'])->name('get.student.enrollment.additional.paid');
        Route::post('paid/{sectionCode}', [\App\Http\Controllers\Student\Enrollment\CreatePaidAdditionalController::class, 'create'])->name('post.student.enrollment.additional.paid');

    });

    Route::prefix('assignment')->group(function () {
        Route::get('show/{enrollmentSession}', \App\Http\Controllers\Student\Enrollment\ShowAssignmentController::class)
            ->name('get.student.enrollment.assignment.show');
        Route::get('show-enrollment/{enrollment}', \App\Http\Controllers\Student\Enrollment\ShowAssignmentFromEnrollmentController::class)
            ->name('get.student.enrollment.assignment.show_enrollment');


        Route::prefix('chapter')->group(function () {
            Route::get('/download/{file}', \App\Http\Controllers\Student\Enrollment\DownloadGuideChapterController::class)
                ->name('get.student.enrollment.assignment.chapter.download');
        });

    });

    Route::prefix('change')->group(function () {

        Route::prefix('section')->group(function () {
            Route::get('{enrollment}', [\App\Http\Controllers\Student\Enrollment\ChangeSectionController::class, 'configView'])->name('get.student.enrollment.change.section');
            Route::post('{enrollment}', [\App\Http\Controllers\Student\Enrollment\ChangeSectionController::class, 'change'])->name('post.student.enrollment.change.section');
        });
    });

    Route::get('refund/{enrollment}', \App\Http\Controllers\Student\Enrollment\RefundEnrollmentController::class)->name('get.student.enrollment.refund');

    Route::get('view/{enrollment}', \App\Http\Controllers\Student\Enrollment\ShowEnrollmentController::class)->name('get.student.enrollment.show');


    Route::prefix('survey')->group(function () {
        Route::get('take-default/{enrollment}', [\App\Http\Controllers\Student\Survey\TakeSurveyController::class, 'takeDefault'])->name('get.student.enrollment.survey.take.default');
        Route::get('take/{enrollment}/{survey}', [\App\Http\Controllers\Student\Survey\TakeSurveyController::class, 'takeSurvey'])->name('get.student.enrollment.survey.take');
    });

    Route::prefix('past')->group(function () {
        Route::get('/', \App\Http\Controllers\Student\Enrollment\Past\IndexController::class)->name('get.student.enrollment.past.index');
    });

});

Route::prefix('experience')->group(function () {

    Route::get('/{status?}', \App\Http\Controllers\Student\Experience\IndexController::class)->name('get.student.experience.index');

    Route::get('/join/{experience}', \App\Http\Controllers\Student\Experience\JoinExperienceController::class)->name('get.student.experience.join');

});

Route::prefix('payments')->group(function () {

    Route::get('', \App\Http\Controllers\Student\Payment\IndexController::class)->name('get.student.payment.index');

});

Route::prefix('session')->group(function () {


    Route::prefix('calendar')->group(function () {
        Route::get('/show/{session}', \App\Http\Controllers\Student\Session\Calendar\ShowSessionController::class)->name('get.student.session.calendar.show');
    });


    Route::prefix('intro')->group(function () {
        Route::get('set/{enrollment}', \App\Http\Controllers\Student\Session\SetIntroSessionController::class)->name('get.student.session.intro.set');
    });

    Route::group(['prefix' => 'book'], function () {

        Route::get('/cancel/{enrollmentSession}', \App\Http\Controllers\Student\Session\Book\CancelEnrollmentSessionController::class)
            ->name('get.student.session.book.cancel');

        Route::group(['prefix' => 'reschedule'], function () {

            Route::get('/init/{enrollmentSession}', [\App\Http\Controllers\Student\Session\Reschedule\RescheduleController::class, 'configSelectDateView'])
                ->name('get.student.session.book.reschedule.init');

        });

        Route::group(['prefix' => 'extra-session'], function () {

            Route::get('show-search-form-flex/{enrollment}/{sessionOrder}', \App\Http\Controllers\Student\Session\ExtraSession\ShowSearchFormController::class)
                ->name('get.student.session.book.extra_session.use');


            Route::post('search-coach/{enrollment}/{sessionOrder}', [\App\Http\Controllers\Student\Session\ExtraSession\SearchCoachController::class, 'postRequest'])
                ->name('post.student.session.book.extra_session.search_coach');
            //llega al post y redirecciona al get...
            Route::get('search-coach/{enrollment}/{sessionOrder}/{dateSession}/{time}/{coach?}', [\App\Http\Controllers\Student\Session\ExtraSession\SearchCoachController::class, 'getRequest'])
                ->name('get.student.session.book.extra_session.search_coach');

            Route::post('/show-coach/{enrollment}/{sessionOrder}', [\App\Http\Controllers\Student\Session\ExtraSession\ShowCoachController::class, 'showCoachFromPost'])
                ->name('post.student.session.book.extra_session.show_coach');

            Route::post('/create-session/{enrollment}/{sessionOrder}', \App\Http\Controllers\Student\Session\ExtraSession\CreateEnrollmentSessionController::class)
                ->name('post.student.session.book.extra_session.store');

        });

        Route::group(['prefix' => 'makeup'], function () {

            Route::group(['prefix' => 'use'], function () {

                Route::get('in-booked-session/{enrollmentSession}', \App\Http\Controllers\Student\Session\Makeup\UseInBookedSessionController::class)
                    ->name('get.student.session.book.makeup.use.booked_session');

                Route::get('in-no-booked-session/{enrollment}/{sessionOrder}', \App\Http\Controllers\Student\Session\Makeup\UseInNoBookedSessionController::class)
                    ->name('get.student.session.book.makeup.use.no_booked_session');
            });

            Route::group(['prefix' => 'buy'], function () {

                Route::get('{enrollment}', [\App\Http\Controllers\Student\Session\Makeup\BuyMakeupController::class, 'configView'])->name('get.student.session.book.makeup.buy');

                Route::post('{enrollment}', [\App\Http\Controllers\Student\Session\Makeup\BuyMakeupController::class, 'buy'])->name('post.student.session.book.makeup.buy');
            });

        });

        Route::group(['prefix' => 'last-minute'], function () {
            Route::get('{enrollment}/{sessionOrder}/{dateSession}/{timeHour}/{coach?}',
                [\App\Http\Controllers\Student\Session\LastMinute\LastMinuteController::class, 'configView']
            )->name('get.student.session.last_minute.use');

            Route::get('{enrollment}/{sessionOrder}/{session}',
                [\App\Http\Controllers\Student\Session\LastMinute\LastMinuteController::class, 'selectSession']
            )->name('get.student.session.last_minute.select_session');

        });

        //reservar una sesión
        Route::group(['prefix' => 'create'], function () {

            //1º mostrar datos sessión, calendario con sesiones del curso, formulario búsqueda a partir de fecha y rango de horas...
            Route::get('/search-coach/{enrollment}/{sessionOrder}', [\App\Http\Controllers\Student\Session\Book\AvailabilityController::class, 'configSelectDateView'])
                ->name('get.student.session.book.create.search_coach');

            //2ª mostrar los tramos horarios y los coaches con disponiblidad en esas horas
            Route::post('/search-coach/{enrollment}/{sessionOrder}', [\App\Http\Controllers\Student\Session\Book\AvailabilityController::class, 'searchCoach'])
                ->name('post.student.session.book.create.search_coach');
            Route::get('/search-coach-full/{enrollment}/{sessionOrder}/{dateSession}/{time}/{coach?}', [\App\Http\Controllers\Student\Session\Book\AvailabilityController::class, 'searchCoachFull'])
                ->name('get.student.session.book.create.search_coach_full');  //from  redirect

            //3º mostrar opciones del coach de horarios dentro de un tramo horario
            Route::post('/show-coach/{enrollment}/{sessionOrder}', [\App\Http\Controllers\Student\Session\Book\ShowCoachController::class, 'showCoachFromPost'])
                ->name('post.student.session.book.create.show_coach');
            Route::get('/show-coach-full/{enrollment}/{sessionOrder}', [\App\Http\Controllers\Student\Session\Book\ShowCoachController::class, 'showCoachFromUri'])
                ->name('get.student.session.book.create.show_coach_full');   //from  redirect

            //4º finalmente, seleccionar la sesión
            Route::post('/create-session/{enrollment}/{sessionOrder}', \App\Http\Controllers\Student\Session\Book\CreateEnrollmentSessionController::class)
                ->name('post.student.session.book.create.store');


            //agendar en una sesión ya existente
            Route::get('schedule-session/{session}/{enrollment}/{sessionOrder}', \App\Http\Controllers\Student\Session\Book\ScheduleSessionController::class)->name('get.student.session.book.session.schedule');
        });

        Route::group(['prefix' => 'suggestions'], function () {

            Route::get('next-sessions/{enrollmentSession}', [\App\Http\Controllers\Student\Session\Book\SuggestionsNextSessionsController::class, 'showSuggestions'])
                ->name('get.student.session.book.create.suggestions.next_sessions.show');
        });

    });

    Route::get('show-session/{session}/{enrollment}/{sessionOrder}', \App\Http\Controllers\Student\Session\Book\ShowSessionController::class)
        ->name('get.student.session.show');

    //Route::get('join-session/{session}/{enrollment}', \App\Http\Controllers\Student\Session\Book\JoinSessionController::class)->name('get.student.session.book.session.join');
    Route::get('join-session/{enrollmentSession}', \App\Http\Controllers\Student\Session\Book\JoinSessionController::class)->name('get.student.session.book.session.join');

    Route::group(['prefix' => 'coach-review'], function () {
        Route::get('{enrollmentSession}', [\App\Http\Controllers\Student\CoachReview\CreateReviewController::class, 'configView'])
            ->name('get.student.session.coach_review.create');
        Route::post('{enrollmentSession}', [\App\Http\Controllers\Student\CoachReview\CreateReviewController::class, 'create'])
            ->name('post.student.session.coach_review.create');
    });

});


Route::prefix('support')->group(function () {

    Route::get('', \App\Http\Controllers\Student\Support\IndexController::class)->name('get.student.support.index');

    Route::prefix('issue')->group(function () {
        Route::post('create', [\App\Http\Controllers\Student\Support\CreateIssueController::class, 'create'])->name('post.student.support.issue.create');
    });
});


Route::prefix('profile')->group(function () {

    Route::get('edit', [\App\Http\Controllers\Student\Profile\EditProfileController::class, 'configView'])->name('get.student.profile.edit');

    Route::post('edit', [\App\Http\Controllers\Student\Profile\EditProfileController::class, 'update'])->name('post.student.profile.edit');

});
