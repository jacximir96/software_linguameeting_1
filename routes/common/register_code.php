<?php

Route::group(['prefix' => 'register-code', 'middleware' => ['auth']], function () {


    Route::prefix('bookstore-request')->group(function () {

        Route::match(['get', 'post'], '/search', \App\Http\Controllers\RegisterCode\BookstoreRequest\SearchController::class)
            ->name('get.admin.register_code.bookstore_request.search');

        Route::get('show/{request}', \App\Http\Controllers\RegisterCode\BookstoreRequest\ShowController::class)
            ->name('get.admin.register_code.bookstore_request.show');

        Route::prefix('download')->group(function () {

            Route::get('pdf/{request}', \App\Http\Controllers\RegisterCode\BookstoreRequest\DownloadPdfController::class)
                ->name('get.admin.register_code.bookstore_request.download.pdf');

            Route::get('excel/{request}', \App\Http\Controllers\RegisterCode\BookstoreRequest\DownloadExcelController::class)
                ->name('get.admin.register_code.bookstore_request.download.excel');

        });


        //Route::get('download/{file}', \App\Http\Controllers\RegisterCode\BookstoreRequest\DownloadController::class)
        //    ->name('get.admin.register_code.bookstore_request.download');

        Route::get('create', [\App\Http\Controllers\RegisterCode\BookstoreRequest\CreateController::class, 'configView'])
            ->name('get.admin.register_code.bookstore_request.create');
        Route::post('create', [\App\Http\Controllers\RegisterCode\BookstoreRequest\CreateController::class, 'create'])
            ->name('post.admin.university.bookstore.request.create');

        Route::get('delete/{request}', \App\Http\Controllers\RegisterCode\BookstoreRequest\DeleteController::class)
            ->name('get.admin.register_code.bookstore_request.delete');

        Route::get('/{newRequest?}', \App\Http\Controllers\RegisterCode\BookstoreRequest\IndexController::class)
            ->name('get.admin.register_code.bookstore_request.index');
    });


    Route::prefix('code')->group(function () {

        Route::get('', \App\Http\Controllers\RegisterCode\Code\IndexController::class)
            ->name('get.admin.register_code.code.index');

        Route::match(['get', 'post'], '/search', \App\Http\Controllers\RegisterCode\Code\SearchController::class)
            ->name('get.admin.register_code.code.search');

        Route::get('/create', \App\Http\Controllers\RegisterCode\Code\CreateCodeController::class)->name('get.admin.register_code.code.create');

        Route::get('change-status/{code}', \App\Http\Controllers\RegisterCode\Code\ChangeStatusController::class)
            ->name('get.admin.register_code.bookstore_request.change_status');

        Route::get('delete/{code}', \App\Http\Controllers\RegisterCode\Code\DeleteController::class)
            ->name('get.admin.register_code.code.delete');
    });
});
