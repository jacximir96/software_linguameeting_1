<?php
Route::prefix('config')->group(function () {

    Route::prefix('billing')->group(function () {

        Route::prefix('incentive')->group(function () {

            Route::prefix('options')->group(function () {

                Route::get('', \App\Http\Controllers\Admin\Coach\Billing\Config\IncentiveType\IndexController::class)
                    ->name('get.admin.coach.billing.config.incentive.options.index');

                Route::get('/create', [\App\Http\Controllers\Admin\Coach\Billing\Config\IncentiveType\CreateIncentiveTypeController::class, 'configView'])
                    ->name('get.admin.coach.billing.config.incentive.options.create');
                Route::post('/create', [\App\Http\Controllers\Admin\Coach\Billing\Config\IncentiveType\CreateIncentiveTypeController::class, 'create'])
                    ->name('post.admin.coach.billing.config.incentive.options.create');

                Route::get('/edit/{incentiveType}', [\App\Http\Controllers\Admin\Coach\Billing\Config\IncentiveType\EditIncentiveTypeController::class, 'configView'])
                    ->name('get.admin.coach.billing.config.incentive.options.edit');
                Route::post('/edit/{incentiveType}', [\App\Http\Controllers\Admin\Coach\Billing\Config\IncentiveType\EditIncentiveTypeController::class, 'update'])
                    ->name('post.admin.coach.billing.config.incentive.options.update');

                Route::get('/delete/{incentiveType}', \App\Http\Controllers\Admin\Coach\Billing\Config\IncentiveType\DeleteIncentiveTypeController::class)
                    ->name('get.admin.coach.billing.config.incentive.options.delete');
            });
        });

        Route::prefix('discount')->group(function () {

            Route::prefix('options')->group(function () {

                Route::get('', \App\Http\Controllers\Admin\Coach\Billing\Config\DiscountType\IndexController::class)
                    ->name('get.admin.coach.billing.config.discount.options.index');

                Route::get('/create', [\App\Http\Controllers\Admin\Coach\Billing\Config\DiscountType\CreateDiscountTypeController::class, 'configView'])
                    ->name('get.admin.coach.billing.config.discount.options.create');
                Route::post('/create', [\App\Http\Controllers\Admin\Coach\Billing\Config\DiscountType\CreateDiscountTypeController::class, 'create'])
                    ->name('post.admin.coach.billing.config.discount.options.create');

                Route::get('/edit/{discountType}', [\App\Http\Controllers\Admin\Coach\Billing\Config\DiscountType\EditDiscountTypeController::class, 'configView'])
                    ->name('get.admin.coach.billing.config.discount.options.edit');
                Route::post('/edit/{discountType}', [\App\Http\Controllers\Admin\Coach\Billing\Config\DiscountType\EditDiscountTypeController::class, 'update'])
                    ->name('post.admin.coach.billing.config.discount.options.update');

                Route::get('/delete/{discountType}', \App\Http\Controllers\Admin\Coach\Billing\Config\DiscountType\DeleteDiscountTypeController::class)
                    ->name('get.admin.coach.billing.config.discount.options.delete');
            });
        });

        Route::prefix('invoice')->group(function () {

            Route::prefix('info-paid')->group(function () {
                Route::get('edit', [\App\Http\Controllers\Admin\Coach\Billing\Config\Invoice\EditInfoPaidController::class, 'configView'])
                    ->name('get.admin.coach.billing.config.invoice.info_paid.edit');
                Route::post('update', [\App\Http\Controllers\Admin\Coach\Billing\Config\Invoice\EditInfoPaidController::class, 'update'])
                    ->name('post.admin.coach.billing.config.invoice.info_paid.update');
            });
        });
    });
});

Route::prefix('coach')->group(function () {

    Route::prefix('billing')->group(function () {

        Route::prefix('for-all')->group(function () {

            Route::get('', \App\Http\Controllers\Admin\Coach\Billing\ForAll\IndexController::class)
                ->name('get.admin.coach.billing.for_all.index');

            Route::post('search', [\App\Http\Controllers\Admin\Coach\Billing\ForAll\SearchController::class, 'fromRequest'])
                ->name('post.admin.coach.billing.for_all.search');

            Route::get('search-get/{month}/{year}', [\App\Http\Controllers\Admin\Coach\Billing\ForAll\SearchController::class, 'fromUrl'])
                ->name('get.admin.coach.billing.for_all.search');

            Route::prefix('file')->group(function () {
                Route::get('/download-billing/{month}/{year}', \App\Http\Controllers\Admin\Coach\Billing\ForAll\File\DownloadController::class)
                    ->name('get.admin.coach.billing.for_all.file.download_billing');

                Route::get('/download-batch-payment/{month}/{year}', \App\Http\Controllers\Admin\Coach\Billing\ForAll\File\DownloadBatchPaymentController::class)
                    ->name('get.admin.coach.billing.for_all.file.download_batch_payment');

                Route::get('/download-paypal-batch-payment/{month}/{year}', \App\Http\Controllers\Admin\Coach\Billing\ForAll\File\DownloadPaypalBatchPaymentController::class)
                    ->name('get.admin.coach.billing.for_all.file.download_paypal_batch_payment');
            });
        });

        Route::prefix('for-one')->group(function () {

            //main page with billing coach information
            Route::get('show/{coach}', \App\Http\Controllers\Admin\Coach\Billing\ForOne\ShowController::class)
                ->name('get.admin.coach.billing.for_one.show');

            //show form with month-year to show salary and concepts of one coach
            Route::get('filter/{coach}', [\App\Http\Controllers\Admin\Coach\Billing\ForOne\FilterBillingController::class, 'configView'])
                ->name('get.admin.coach.billing.for_one.filter');

            Route::post('filter/{coach}', [\App\Http\Controllers\Admin\Coach\Billing\ForOne\FilterBillingController::class, 'filter'])
                ->name('post.admin.coach.billing.for_one.filter');


        });


        Route::prefix('discount')->group(function () {

            Route::get('/create/{coach}', [\App\Http\Controllers\Admin\Coach\Billing\Discount\CreateDiscountController::class, 'configView'])
                ->name('get.admin.coach.billing.discount.create');

            Route::post('/create/{coach}', [\App\Http\Controllers\Admin\Coach\Billing\Discount\CreateDiscountController::class, 'create'])
                ->name('post.admin.coach.billing.discount.create');

            Route::get('/edit/{discount}', [\App\Http\Controllers\Admin\Coach\Billing\Discount\EditDiscountController::class, 'configView'])
                ->name('get.admin.coach.billing.discount.edit');

            Route::post('/update/{discount}', [\App\Http\Controllers\Admin\Coach\Billing\Discount\EditDiscountController::class, 'update'])
                ->name('post.admin.coach.billing.discount.update');

            Route::get('/delete/{discount}', \App\Http\Controllers\Admin\Coach\Billing\Discount\DeleteDiscountController::class)
                ->name('get.admin.coach.billing.discount.delete');
        });

        Route::prefix('incentive')->group(function () {

            Route::get('/create/{coach}', [\App\Http\Controllers\Admin\Coach\Billing\Incentive\CreateIncentiveController::class, 'configView'])
                ->name('get.admin.coach.billing.incentive.create');

            Route::post('/create/{coach}', [\App\Http\Controllers\Admin\Coach\Billing\Incentive\CreateIncentiveController::class, 'create'])
                ->name('post.admin.coach.billing.incentive.create');

            Route::get('/edit/{incentive}', [\App\Http\Controllers\Admin\Coach\Billing\Incentive\EditIncentiveController::class, 'configView'])
                ->name('get.admin.coach.billing.incentive.edit');

            Route::post('/update/{incentive}', [\App\Http\Controllers\Admin\Coach\Billing\Incentive\EditIncentiveController::class, 'update'])
                ->name('post.admin.coach.billing.incentive.update');

            Route::get('/delete/{incentive}', \App\Http\Controllers\Admin\Coach\Billing\Incentive\DeleteIncentiveController::class)
                ->name('get.admin.coach.billing.incentive.delete');

        });

        Route::prefix('invoice')->group(function () {

            Route::get('/list/{coach}', \App\Http\Controllers\Admin\Coach\Billing\Invoice\InvoiceCoachListController::class)
                ->name('get.admin.coach.billing.invoice.coach_list');

            Route::post('/generate/{coach}',
                [\App\Http\Controllers\Admin\Coach\Billing\Invoice\GenerateAndDownloadInvoiceController::class, 'fromRequest'])
                ->name('post.admin.coach.billing.invoice.generate_download.from_request');
            Route::get('/generate-from-url/{coach}/{month}/{year}',
                [\App\Http\Controllers\Admin\Coach\Billing\Invoice\GenerateAndDownloadInvoiceController::class, 'fromUrlParameters'])
                ->name('get.admin.coach.billing.invoice.generate_download.from_url');

            Route::get('/delete/{invoice}', \App\Http\Controllers\Admin\Coach\Billing\Invoice\DeleteInvoiceController::class)
                ->name('get.admin.coach.billing.invoice.delete');

            Route::get('/download/{invoice}', \App\Http\Controllers\Admin\Coach\Billing\Invoice\DownloadInvoiceController::class)
                ->name('get.admin.coach.billing.invoice.download');
        });

        Route::prefix('salary')->group(function () {

            Route::get('/create/{coach}', [\App\Http\Controllers\Admin\Coach\Billing\Salary\CreateSalaryCoachController::class, 'configView'])
                ->name('get.admin.coach.billing.salary.create');

            Route::post('/create/{coach}', [\App\Http\Controllers\Admin\Coach\Billing\Salary\CreateSalaryCoachController::class, 'create'])
                ->name('post.admin.coach.billing.salary.create');

            Route::get('/edit/{salary}', [\App\Http\Controllers\Admin\Coach\Billing\Salary\EditSalaryCoachController::class, 'configView'])
                ->name('get.admin.coach.billing.salary.edit');

            Route::post('/edit/{salary}', [\App\Http\Controllers\Admin\Coach\Billing\Salary\EditSalaryCoachController::class, 'update'])
                ->name('post.admin.coach.billing.salary.update');


            Route::prefix('coordinators')->group(function () {

                Route::get('', \App\Http\Controllers\Admin\Coach\Billing\Salary\IndexCoordinatorController::class)
                    ->name('get.admin.coach.billing.salary.coordinators.index');
            });
        });
    });
});
