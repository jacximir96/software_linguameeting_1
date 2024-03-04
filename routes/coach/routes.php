<?php

Route::prefix('dashboard')->group(function () {
    Route::get('/', \App\Http\Controllers\Coach\DashboardController::class)->name('get.coach.dashboard');
});

Route::prefix('billing')->group(function () {

    Route::prefix('for-one')->group(function (){

        //show filtered salary and conceptos of one coach
        Route::get('/show-filtered/{coach}/{month}/{year}', \App\Http\Controllers\Coach\Billing\ForOne\ShowFilteredController::class)
            ->name('get.coach.billing.for_one.show_filtered');

        //show salary and concepts for coordinated coaches of a coach
        Route::get('/show-coordinated/{coach}/{month}/{year}', \App\Http\Controllers\Coach\Billing\ForOne\ShowCoordinatedController::class)
            ->name('get.coach.billing.for_one.show_coordinated');

    });


    Route::prefix('profile')->group(function () {
        Route::get('edit', [\App\Http\Controllers\Coach\Billing\UpdateBillingInfoController::class, 'configView'])->name('get.coach.billing.profile.edit');
        Route::post('edit', [\App\Http\Controllers\Coach\Billing\UpdateBillingInfoController::class, 'update'])->name('post.coach.billing.profile.update');
    });

    Route::prefix('invoices')->group(function () {
        Route::get('', App\Http\Controllers\Coach\Invoice\IndexController::class)->name('get.coach.billing.invoice.index');
        Route::get('download/{invoice}', \App\Http\Controllers\Coach\Invoice\DownloadInvoiceController::class)->name('get.coach.billing.invoice.download');
    });
});


Route::prefix('calendar')->group(function () {

    Route::get('/show', \App\Http\Controllers\Coach\Calendar\ShowController::class)
        ->name('get.coach.calendar.show');

    Route::prefix('google')->group(function () {

        Route::get('/generate', [\App\Http\Controllers\Coach\GoogleCalendar\GenerateController::class, 'configView'])->name('get.coach.calendar.google.generate');
        Route::post('/generate', [\App\Http\Controllers\Coach\GoogleCalendar\GenerateController::class, 'generate'])->name('post.coach.calendar.google.generate');
    });

    Route::prefix('session')->group(function () {

        Route::get('/show/{session}', \App\Http\Controllers\Coach\Calendar\ShowSessionController::class)
            ->name('get.coach.calendar.availability.session.show')
            ->middleware('session.coach.is_owner');
    });
});

Route::prefix('class')->group(function () {

    Route::prefix('today')->group(function () {
        Route::get('', \App\Http\Controllers\Coach\Class\ClassTodayIndexController::class)->name('get.coach.class.today.index');

    });

});


Route::prefix('schedule')->group(function () {
    Route::get('/show/{startDate?}/{endDate?}', \App\Http\Controllers\Coach\Schedule\ShowController::class)->name('get.coach.schedule.show');

    Route::prefix('availability')->group(function () {

        Route::get('/create/{coach?}/{date?}',
            [\App\Http\Controllers\Coach\Schedule\Availability\CreateController::class, 'configView'])
            ->name('get.coach.schedule.availability.create');
        Route::post('/create/{coach?}/{date?}', [\App\Http\Controllers\Coach\Schedule\Availability\CreateController::class, 'create'])
            ->name('post.coach.schedule.availability.create');

        Route::get('/edit/{coach}/{date}/{startHour}/{endHour}', [\App\Http\Controllers\Coach\Schedule\Availability\EditController::class, 'configView'])
            ->name('get.coach.schedule.availability.edit');
        Route::post('/edit/{coach}/{date}/{startHour}/{endHour}', [\App\Http\Controllers\Coach\Schedule\Availability\EditController::class, 'update'])
            ->name('post.coach.schedule.availability.update');
    });
});

Route::prefix('course')->group(function () {

    Route::get('/index', \App\Http\Controllers\Coach\Course\IndexController::class)->name('get.coach.course.index');

    Route::get('/show/{course}', \App\Http\Controllers\Coach\Course\ShowCourseController::class)->name('get.coach.course.show');

    Route::match(['get', 'post'], '/search', \App\Http\Controllers\Coach\Course\SearchController::class)->name('post.coach.course.search');
});

Route::prefix('experiences')->group(function () {

    Route::get('', \App\Http\Controllers\Coach\Experience\IndexController::class)->name('get.coach.experience.index');
});

Route::prefix('feedback')->group(function () {

    Route::prefix('instructor')->group(function () {
        Route::get('', \App\Http\Controllers\Coach\Feedback\Instructor\IndexController::class)->name('get.coach.feedback.instructor.index');
    });

    Route::prefix('manager')->group(function () {

        Route::get('', \App\Http\Controllers\Coach\Feedback\Manager\IndexController::class)->name('get.coach.feedback.manager.index');

        Route::get('download/{file}', \App\Http\Controllers\Coach\Feedback\Manager\DownloadFileController::class)
            ->name('get.coach.feedback.manager.file.download')
            ->middleware('evaluation_is_from_coach');
    });


    Route::prefix('student')->group(function () {
        Route::get('', \App\Http\Controllers\Coach\Feedback\Student\IndexController::class)->name('get.coach.feedback.student.index');
        Route::match(['get', 'post'], '/search', \App\Http\Controllers\Coach\Feedback\Student\SearchReviewController::class)->name('post.coach.feedback.student.search');

        Route::prefix('favorite')->group(function () {
            Route::get('mark-as-favorite/{coachReview}', \App\Http\Controllers\Coach\Feedback\Student\MarkFavoriteController::class)->name('get.coach.feedback.student.favorite.mark');
        });
    });


});

Route::prefix('help')->group(function () {

    Route::get('', \App\Http\Controllers\Coach\Help\IndexController::class)->name('get.coach.help.index');
});

Route::prefix('messaging')->group(function () {

    Route::get('', \App\Http\Controllers\Coach\Messaging\IndexController::class)->name('get.coach.messaging.index');

});


Route::prefix('profile')->group(function () {

    Route::get('edit', [\App\Http\Controllers\Coach\Profile\EditProfileController::class, 'configView'])->name('get.coach.profile.edit');

    Route::post('edit', [\App\Http\Controllers\Coach\Profile\EditProfileController::class, 'update'])->name('post.coach.profile.edit');

});
