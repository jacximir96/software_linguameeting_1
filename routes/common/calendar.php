<?php

Route::prefix('session')->group(function () {

    Route::get('/block/{session}', \App\Http\Controllers\Admin\Calendar\BlockSessionController::class)->name('get.calendar.session.block');
});

