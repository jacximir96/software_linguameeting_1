<?php

Route::prefix('payment')->group(function () {

    Route::get('', \App\Http\Controllers\Admin\Payment\IndexController::class)->name('get.admin.payment.index');
});
