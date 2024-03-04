<?php

Route::prefix('api')->group(function () {

    Route::prefix('coach')->group(function () {

        Route::prefix('billing')->group(function () {

            Route::prefix('payment')->group(function () {

                Route::post('change-paid/{payment}', \App\Http\Controllers\Api\Coach\Billing\Payment\ChangePaidController::class)
                    ->name('post.admin.api.coach.billing.payment.change_paid');
            });

            Route::prefix('payment')->group(function () {
                Route::get('/generate-from-month/{month}/{year}', \App\Http\Controllers\Api\Coach\Billing\Invoice\GenerateMonthInvoiceController::class)
                    ->name('get.admin.api.coach.billing.invoice.generate_from_month');
            });
        });

        Route::prefix('calendar')->group(function () {

            Route::prefix('events')->group(function () {

                Route::get('get/{coach?}/{startDate?}/{endDate?}/{gridType?}', \App\Http\Controllers\Api\Coach\Calendar\Event\GetEventController::class)->name('get.admin.api.coach.calendar.events.get');
            });
        });

        Route::prefix('coordinator')->group(function () {
            Route::post('/{coach}', \App\Http\Controllers\Api\Coach\Coordinator\ChangeCoordinatorController::class)
                ->name('post.admin.api.coach.coordinator.change');
        });


        Route::prefix('schedule')->group(function () {

            Route::prefix('events')->group(function () {

                Route::get('get/{coach?}/{startDate?}/{endDate?}/{gridType?}', \App\Http\Controllers\Api\Coach\Schedule\Event\GetEventController::class)->name('get.admin.api.coach.schedule.events.get');
            });
        });

        Route::prefix('semester')->group(function () {
            Route::post('finished/{coach}', \App\Http\Controllers\Api\Coach\Semester\ChangeFinishedController::class)
                ->name('post.admin.api.coach.semester.finished.change');
        });
    });

    Route::prefix('course')->group(function () {

        Route::prefix('session')->group(function () {

            Route::post('/status-change/{enrollmentSession}', \App\Http\Controllers\Api\Course\Session\ChangeSessionStatusController::class)
                ->name('post.admin.api.course.session.status.change');


            Route::prefix('feedback')->group(function () {

                Route::prefix('student')->group(function () {

                    Route::post('/change/{enrollmentSession}', \App\Http\Controllers\Api\Course\Session\Review\ChangeStudentReviewController::class)
                        ->name('post.admin.api.course.session.feedback.student.change');
                });
            });
        });
    });


    Route::prefix('course-coordinator')->group(function () {

        Route::post('/assign/{course}', \App\Http\Controllers\Api\CourseCoordinator\AssignCourseCoordinatorController::class)
            ->name('post.admin.api.course_coordinator.assign');
        Route::get('/remove/{course}', \App\Http\Controllers\Api\CourseCoordinator\RemoveCourseCoordinatorController::class)
            ->name('get.admin.api.course_coordinator.remove');

    });


    Route::prefix('section')->group(function () {

        Route::prefix('assignment')->group(function () {


        });
    });

    Route::prefix('options')->group(function () {

        Route::prefix('course')->group(function () {

            Route::get('belong-to-university/{university}', \App\Http\Controllers\Api\Options\Course\IndexController::class)
                ->name('get.admin.api.options.course.belongs_to_university');

            Route::post('belong-to-university/{university}', \App\Http\Controllers\Api\Options\Course\IndexController::class)
                ->name('post.admin.api.options.course.belongs_to_university');

            Route::post('from-multiple-university', \App\Http\Controllers\Api\Options\Course\MultipleController::class)
                ->name('post.admin.api.options.course.from_multiple_university');

        });

        Route::prefix('guide')->group(function () {

            Route::get('language/{guideOrigin}/{language}', [\App\Http\Controllers\Api\Options\Guides\IndexController::class, 'obtainGuideByOriginAndLanguage'])
                ->name('post.admin.api.options.guides.origin_language');

        });

        Route::prefix('notification')->group(function () {

            Route::get('type-from-level/{level?}', [App\Http\Controllers\Api\Options\Notification\IndexController::class, 'obtainTypesFromLevel'])
                ->name('get.admin.api.options.notification.type_from_level');
        });

    });


    Route::prefix('student')->group(function () {

        Route::prefix('calendar')->group(function () {

            Route::prefix('events')->group(function () {

                Route::get('get/{student?}/{startDate?}/{endDate?}/{gridType?}', \App\Http\Controllers\Api\Student\Calendar\Event\GetEventController::class)->name('get.admin.api.student.calendar.events.get');
            });
        });

    });

    Route::prefix('users')->group(function () {
        Route::prefix('search')->group(function () {

            Route::prefix('autocomplete')->group(function () {

                Route::post('', [\App\Http\Controllers\Api\User\SearchUserController::class, 'searchForAutocomplete'])
                    ->name('post.admin.api.users.search.autocomplete');
            });
        });

        Route::prefix('status')->group(function () {
            Route::post('change/{user}', \App\Http\Controllers\Api\User\ChangeStatusController::class)
                ->name('post.admin.api.users.status.change');
        });

    });
});
