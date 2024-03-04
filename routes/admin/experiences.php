<?php
Route::prefix('experience')->group(function () {

    Route::get('/', \App\Http\Controllers\Admin\Experience\IndexController::class)->name('get.admin.experience.index');

    Route::get('/create', [\App\Http\Controllers\Admin\Experience\CreateController::class, 'configView'])->name('get.admin.experience.create');
    Route::post('/create', [\App\Http\Controllers\Admin\Experience\CreateController::class, 'create'])->name('post.admin.experience.create');

    Route::get('/delete/{experience}', \App\Http\Controllers\Admin\Experience\DeleteController::class)->name('get.admin.experience.delete');

    Route::get('/edit/{experience}', [\App\Http\Controllers\Admin\Experience\EditController::class, 'configView'])->name('get.admin.experience.edit');
    Route::post('/edit/{experience}', [\App\Http\Controllers\Admin\Experience\EditController::class, 'update'])->name('post.admin.experience.edit');

    Route::get('attendees/{experience}', \App\Http\Controllers\Admin\Experience\AttendeesIndexController::class)->name('get.admin.experience.attendees.index');
    Route::get('attendees-excel/{experience}', \App\Http\Controllers\Admin\Experience\DownloadAttendeesExcelController::class)->name('get.admin.experience.attendees.excel');

    Route::get('public-attendees/{experience}', \App\Http\Controllers\Admin\Experience\PublicAtteendesIndexController::class)->name('get.admin.experience.public_attendees.index');
    Route::get('public-attendees-excel/{experience}', \App\Http\Controllers\Admin\Experience\DownloadPublicAttendeesExcelController::class)->name('get.admin.experience.public_attendees.excel');

    Route::get('comments/{experience}', \App\Http\Controllers\Admin\Experience\CommentsIndexController::class)->name('get.admin.experience.comments.index');
    Route::get('donations/{experience}', \App\Http\Controllers\Admin\Experience\DonationsIndexController::class)->name('get.admin.experience.donations.index');

    Route::prefix('file')->group(function () {
        Route::get('/delete/{experienceFile}', \App\Http\Controllers\Admin\Experience\File\DeleteExperienceFileController::class)->name('get.admin.experience.file.delete');
    });
});
