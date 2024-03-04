<?php
use App\Http\Controllers\Admin\University\CreateController;
use App\Http\Controllers\Admin\University\SearchController;
use App\Http\Controllers\Admin\University\EditController;
use App\Http\Controllers\Admin\University\ShowController;

Route::prefix('university')->group(function () {

    Route::get('/', \App\Http\Controllers\Admin\University\IndexController::class)->name('get.admin.university.index');

    Route::match(['get', 'post'], '/search', SearchController::class)->name('post.admin.university.search');

    Route::get('/show/{university}', ShowController ::class)->name('get.admin.university.show');

    Route::get('/create', [CreateController::class, 'configView'])->name('get.admin.university.create');
    Route::post('/create', [CreateController::class, 'create'])->name('post.admin.university.create');

    Route::get('/edit/{university}', [EditController::class, 'configView'])->name('get.admin.university.edit');
    Route::post('/edit/{university}', [EditController::class, 'update'])->name('post.admin.university.edit');

    Route::get('/delete/{university}', \App\Http\Controllers\Admin\University\DeleteController::class)->name('get.admin.university.delete');
    Route::get('/restore/{id}', \App\Http\Controllers\Admin\University\RestoreController::class)->name('get.admin.university.restore');

    Route::prefix('group-actions')->group(function () {
        Route::get( '/download-excel', \App\Http\Controllers\Admin\University\DownloadListExcelController::class)->name('get.admin.university.excel.download');
    });



    Route::prefix('instructor')->group(function () {

        Route::get('/assign/{instructor}', [\App\Http\Controllers\Admin\University\Instructor\AssignInstructorController::class, 'configView'])
            ->name('get.admin.university.instructor.assign');
        Route::post('/assign/{instructor}', [\App\Http\Controllers\Admin\University\Instructor\AssignInstructorController::class, 'assign'])
            ->name('post.admin.university.instructor.assign');

        Route::get('/delete/{instructor}/{university}', [\App\Http\Controllers\Admin\University\Instructor\UnassignInstructorController::class, 'delete'])
            ->name('get.admin.university.instructor.delete');

    });
});
