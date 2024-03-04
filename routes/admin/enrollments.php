<?php
Route::prefix('enrollments')->group(function () {

    Route::get('/delete/{enrollment}', \App\Http\Controllers\Admin\Student\Enrollment\DeleteController::class)->name('get.admin.enrollment.delete');

});
