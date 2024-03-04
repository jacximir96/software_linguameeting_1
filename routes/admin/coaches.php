<?php
Route::prefix('coach')->group(function () {

    Route::get('/', \App\Http\Controllers\Admin\Coach\IndexController::class)->name('get.admin.coach.index');

    Route::match(['get', 'post'], '/search', \App\Http\Controllers\Admin\Coach\SearchController::class)->name('post.admin.coach.search');

    Route::get('/create/', [\App\Http\Controllers\Admin\Coach\CreateController::class, 'configView'])->name('get.admin.coach.create');
    Route::post('/create/', [\App\Http\Controllers\Admin\Coach\CreateController::class, 'create'])->name('post.admin.coach.create');

    Route::group(['middleware' => 'user_is_coach'], function () {

        Route::get('/show/{coach}', \App\Http\Controllers\Admin\Coach\ShowController::class)->name('get.admin.coach.show');
        Route::get('/edit/{coach}', [\App\Http\Controllers\Admin\Coach\EditController::class, 'configView'])->name('get.admin.coach.edit');
        Route::post('/update/{coach}', [\App\Http\Controllers\Admin\Coach\EditController::class, 'update'])->name('post.admin.coach.update');

        Route::get('/delete/{coach}', \App\Http\Controllers\Admin\Coach\DeleteController::class)->name('get.admin.coach.delete');
        Route::get('/restore/{coach}', \App\Http\Controllers\Admin\Coach\RestoreController::class)->name('get.admin.coach.restore');

        Route::prefix('coach')->group(function () {

            Route::get('/assign-coordinated/{coachCoordinator}', [\App\Http\Controllers\Admin\Coach\Coordinator\AssignCoordinatedController::class, 'configView'])
                ->name('get.admin.coach.assign_coordinated');
            Route::post('/assign-coordinated/{coachCoordinator}', [\App\Http\Controllers\Admin\Coach\Coordinator\AssignCoordinatedController::class, 'assign'])
                ->name('post.admin.coach.assign_coordinated');

            Route::get('/remove-coordinated/{coachCoordinator}/{coach}', \App\Http\Controllers\Admin\Coach\Coordinator\RemoveCoordinatedController::class)
                ->name('get.admin.coach.remove_coordinated');

            Route::get('coordinator-of-show-all/{coach}', \App\Http\Controllers\Admin\Coach\Coordinator\ShowAllCoordinatedController::class)
                ->name('get.admin.coach.coordinator_of.show_all');
        });


        Route::get('/assign-coordinator/{coach}', [\App\Http\Controllers\Admin\Coach\Coordinator\AssignCoordinatorController::class, 'configView'])
            ->name('get.admin.coach.assign_coordinator');
        Route::post('/assign-coordinator/{coach}', [\App\Http\Controllers\Admin\Coach\Coordinator\AssignCoordinatorController::class, 'assign'])
            ->name('post.admin.coach.assign_coordinator');

    });

    Route::prefix('status')->group(function () {
        Route::get('/', \App\Http\Controllers\Admin\Coach\StatusIndexController::class)
            ->name('get.admin.coach.status.index');
    });

    Route::prefix('calendar')->group(function () {

        Route::get('/show/{coach}', \App\Http\Controllers\Admin\Coach\Calendar\ShowController::class)
            ->name('get.admin.coach.calendar.show');

        Route::prefix('session')->group(function () {

            Route::middleware('user_is_admin')->group(function () {
                Route::get('/change-coach/{session}', [\App\Http\Controllers\Admin\Coach\Calendar\ChangeSessionCoachController::class, 'configView'])
                    ->name('get.admin.coach.calendar.availability.session.change_coach');
                Route::post('/change-coach/{session}', [\App\Http\Controllers\Admin\Coach\Calendar\ChangeSessionCoachController::class, 'change'])
                    ->name('post.admin.coach.calendar.availability.session.change_coach');
            });

        });
    });


    Route::prefix('feedbacks')->group(function () {

        Route::get('/show/{coachFeedback}', \App\Http\Controllers\Admin\Coach\Feedback\ShowFeedbackController::class)
            ->name('get.admin.coach.coach_feedback.show');

        Route::get('/show-all/{coach}', \App\Http\Controllers\Admin\Coach\Feedback\ShowAllController::class)
            ->name('get.admin.coach.coach_feedback.show_all');

        Route::get('/create/{coach}', [\App\Http\Controllers\Admin\Coach\Feedback\CreateFeedbackController::class, 'configView'])
            ->name('get.admin.coach.coach_feedback.create');
        Route::post('/create/{coach}', [\App\Http\Controllers\Admin\Coach\Feedback\CreateFeedbackController::class, 'create'])
            ->name('post.admin.coach.coach_feedback.create');

        Route::get('/edit/{coachFeedback}', [\App\Http\Controllers\Admin\Coach\Feedback\EditFeedbackController::class, 'configView'])
            ->name('get.admin.coach.coach_feedback.edit');
        Route::post('/edit/{coachFeedback}', [\App\Http\Controllers\Admin\Coach\Feedback\EditFeedbackController::class, 'update'])
            ->name('post.admin.coach.coach_feedback.update');

        Route::get('download/{coachFeedback}', \App\Http\Controllers\Admin\Coach\Feedback\DownloadFeedbackController::class)
            ->name('get.admin.coach.coach_feedback.download');

        Route::get('/delete/{coachFeedback}', \App\Http\Controllers\Admin\Coach\Feedback\DeleteFeedbackController::class)
            ->name('get.admin.coach.coach_feedback.delete');
    });

    Route::prefix('group-actions')->group(function () {
        Route::get('/download-excel', \App\Http\Controllers\Admin\Coach\DownloadListExcelController::class)->name('get.admin.coach.excel.download');

        Route::get('/write-email', [\App\Http\Controllers\Admin\Coach\SendEmailController::class, 'configView'])->name('get.admin.coach.email.send.config_view');
        Route::post('/send-email', [\App\Http\Controllers\Admin\Coach\SendEmailController::class, 'send'])->name('post.admin.coach.email.send.send');
    });

    Route::prefix('help')->group(function () {

        Route::get('', \App\Http\Controllers\Admin\Coach\Help\IndexController::class)
            ->name('get.admin.coach.help.index');

        Route::get('/create', [\App\Http\Controllers\Admin\Coach\Help\CreateCoachHelpController::class, 'configView'])
            ->name('get.admin.coach.help.create');
        Route::post('/create', [\App\Http\Controllers\Admin\Coach\Help\CreateCoachHelpController::class, 'create'])
            ->name('post.admin.coach.help.create');

        Route::get('/edit/{coachHelp}', [\App\Http\Controllers\Admin\Coach\Help\EditCoachHelpController::class, 'configView'])
            ->name('get.admin.coach.help.edit');
        Route::post('/edit/{coachHelp}', [\App\Http\Controllers\Admin\Coach\Help\EditCoachHelpController::class, 'update'])
            ->name('post.admin.coach.help.update');

        Route::get('/delete/{coachHelp}', \App\Http\Controllers\Admin\Coach\Help\DeleteCoachHelpController::class)
            ->name('get.admin.coach.help.delete');
    });


    Route::prefix('ranking')->group(function () {

        Route::get('/', \App\Http\Controllers\Admin\Coach\Ranking\IndexRankingController::class)->name('get.admin.coach.ranking.index');
        Route::post('/', \App\Http\Controllers\Admin\Coach\Ranking\SearchRankingController::class)->name('post.admin.coach.ranking.search');

        Route::post('update/{coach}/{field}', \App\Http\Controllers\Admin\Coach\Ranking\UpdateRankingController::class)->name('post.admin.coach.ranking.update');

    });

    Route::prefix('reviews')->group(function () {

        Route::get('/', \App\Http\Controllers\Admin\Coach\Review\IndexReviewController::class)->name('get.admin.coach.review.index');
        Route::match(['get', 'post'], '/search', \App\Http\Controllers\Admin\Coach\Review\SearchReviewController::class)->name('post.admin.coach.review.search');

        Route::get('/show/{coachReview}', \App\Http\Controllers\Admin\Coach\Review\ShowController::class)->name('get.admin.coach.review.show');

        Route::get('/show-all/{coach}', \App\Http\Controllers\Admin\Coach\Review\ShowAllController::class)->name('get.admin.coach.review.show_all');

    });

    Route::prefix('schedule')->group(function () {

        Route::get('/show/{coach}/{startDate?}/{endDate?}/{timezone?}', \App\Http\Controllers\Admin\Coach\Schedule\ShowController::class)->name('get.admin.coach.schedule.show');

    });


    Route::prefix('zoom')->group(function () {

        Route::prefix('meeting')->group(function () {

            Route::get('/', \App\Http\Controllers\Admin\Coach\Zoom\IndexZoomMeetingController::class)->name('get.admin.coach.zoom.meeting.index');

            Route::get('/download-excel', \App\Http\Controllers\Admin\Coach\Zoom\DownloadZoomMeetingExcelController::class)->name('get.admin.coach.zoom.meeting.excel.download');
            Route::get('/download-pdf', \App\Http\Controllers\Admin\Coach\Zoom\DownloadZoomMeetingPdfController::class)->name('get.admin.coach.zoom.meeting.pdf.download');
        });


        Route::prefix('zoom-recording')->group(function () {

            Route::get('/show-coach/{coach}', \App\Http\Controllers\Admin\Coach\Recording\ShowAllController::class)
                ->name('get.admin.zoom.zoom_recording.coach.show_all');

            Route::get('/show/{zoomRecording}', \App\Http\Controllers\Admin\Coach\Recording\ShowController::class)
                ->name('get.admin.zoom.zoom_recording.coach.show');
        });
    });
});
