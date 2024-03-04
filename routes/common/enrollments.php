<?php
Route::prefix('enrollments')->group(function () {

    Route::prefix('session')->group(function () {

        Route::prefix('feedback')->group(function () {

            Route::get('/create/{enrollmentSession}', [\App\Http\Controllers\StudentReview\CreateController::class, 'configView'])
                ->name('get.common.enrollments.session.feedback.create')
                ->middleware('student_review.can_update');

            Route::post('/create/{enrollmentSession}', [\App\Http\Controllers\StudentReview\CreateController::class, 'create'])
                ->name('post.common.enrollments.session.feedback.create')
                ->middleware('student_review.can_update');

            Route::middleware('student_review.can_update')->group(function () {
                Route::get('/update/{sessionFeedback}', [\App\Http\Controllers\StudentReview\UpdateController::class, 'configView'])
                    ->name('get.common.enrollments.session.feedback.update');

                Route::post('/update/{sessionFeedback}', [\App\Http\Controllers\StudentReview\UpdateController::class, 'update'])
                    ->name('post.common.enrollments.session.feedback.update');
            });
        });
    });
});
