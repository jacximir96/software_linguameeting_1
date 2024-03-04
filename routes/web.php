<?php


use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\FrontController::class, 'index'])->name('landing');

Route::get('pricing', [App\Http\Controllers\FrontController::class, 'pricing'])->name('pricing');

Route::get('how-it-works/{slug}', [App\Http\Controllers\FrontController::class, 'howWorks'])->name('how-it-works');

Route::prefix('experiences')->group(function () {

    Route::get('/{time?}', [App\Http\Controllers\FrontController::class, 'experiences'])->name('experiences');

    Route::get('experience/{experience}', [App\Http\Controllers\FrontController::class, 'showExperience'])->name('experiences.show');

    Route::get('search/{slug}', [App\Http\Controllers\FrontController::class, 'searchExperience'])->name('searchExperience');

    Route::get('download-vocabulary/{experienceFile}', \App\Http\Controllers\Public\Experience\DownloadVocabularyController::class)->name('experiences.vocabulary.download');

    Route::prefix('book')->group(function () {
        Route::get('{experience}', [\App\Http\Controllers\Public\Experience\PublicRegisterController::class, 'configView'])
            ->name('get.public.experience.book.create');
        Route::post('{experience}', [\App\Http\Controllers\Public\Experience\PublicRegisterController::class, 'book'])
            ->name('post.public.experience.book.create');
    });

    Route::prefix('rate')->group(function () {
        Route::get('create/{experience}', [\App\Http\Controllers\Public\Experience\RateExperienceController::class, 'configView'])
            ->name('get.public.experience.rate.create');
        Route::post('create/{experience}', [\App\Http\Controllers\Public\Experience\RateExperienceController::class, 'comment'])
            ->name('post.public.experience.rate.create');
    });


    Route::prefix('tip')->group(function () {

        Route::get('{experience}', [\App\Http\Controllers\Public\Experience\CreateTipController::class, 'configView'])
            ->name('get.public.experience.tip.create');
        Route::post('{experience}', [\App\Http\Controllers\Public\Experience\CreateTipController::class, 'create'])
            ->name('post.public.experience.tip.create');
    });



});


Route::get('about', [App\Http\Controllers\FrontController::class, 'about'])->name('about');

Route::get('support', [App\Http\Controllers\FrontController::class, 'support'])->name('support');

Route::get('contact', [App\Http\Controllers\FrontController::class, 'contact'])->name('contact');

Route::get('testimonials/{slug}', [App\Http\Controllers\FrontController::class, 'testimonials'])->name('testimonials');

Route::get('case-study/{slug}', [App\Http\Controllers\FrontController::class, 'caseStudy'])->name('case-study');

Route::get('coaches', [App\Http\Controllers\FrontController::class, 'coaches'])->name('coaches');

Route::get('policy', [App\Http\Controllers\FrontController::class, 'policy'])->name('policy');

Route::get('terms', [App\Http\Controllers\FrontController::class, 'terms'])->name('terms');




Auth::routes(['verify' => true]);


Route::prefix('register')->group(function () {

    Route::prefix('student')->group(function () {

        Route::get('code', [\App\Http\Controllers\Auth\Student\RegisterStudentCheckCodeController::class, 'configView'])
            ->name('get.public.register.student.code');
        Route::post('code', [\App\Http\Controllers\Auth\Student\RegisterStudentCheckCodeController::class, 'checkCode'])
            ->name('post.public.register.student.code');

        Route::get('personal-data/{sectionCode}', [\App\Http\Controllers\Auth\Student\RegisterStudentPersonalDataController::class, 'configView'])
            ->name('get.public.register.student.personal_data');
        Route::post('personal-data/{sectionCode}', [\App\Http\Controllers\Auth\Student\RegisterStudentPersonalDataController::class, 'register'])
            ->name('post.public.register.student.personal_data');
    });

    Route::prefix('instructor')->group(function () {
        Route::post('register', \App\Http\Controllers\Auth\Instructor\RegisterController::class)
            ->name('post.public.register.instructor.create');
    });

    Route::prefix('coach')->group(function () {
        Route::get('', [\App\Http\Controllers\Auth\Coach\RegisterCoachFrontController::class, 'configView'])->name('get.public.coach.register.create');
        Route::post('', [\App\Http\Controllers\Auth\Coach\RegisterCoachFrontController::class, 'register'])->name('post.public.coach.register.create');
    });

    Route::prefix('university')->group(function () {
        Route::post('register', \App\Http\Controllers\Auth\University\RegisterController::class)
            ->name('post.public.register.university.create');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::prefix('password')->group(function () {

    Route::get('generate', \App\Http\Controllers\Api\GeneratePassword::class)->name('get.public.password.generate');

});


Route::prefix('file')->group(function () {

    Route::get('check-upload-size/{sizeInKB}', \App\Http\Controllers\Api\CheckFileSize::class)->name('get.public.file.check_upload_size');

});

Route::group(['middleware' => ['auth']], function () {

    Route::get('feedback-modal', function () {
        return view('common.feedback_modal');
    })->name('feedback-modal');

    Route::prefix('profile')->group(function () {

        Route::get('edit', [\App\Http\Controllers\User\EditProfileController::class, 'configView'])->name('get.user.profile.edit');

        Route::post('edit', [\App\Http\Controllers\User\EditProfileController::class, 'update'])->name('post.user.profile.edit');
    });

    Route::prefix('impersonate')->group(function () {

        Route::get('/start/{user}', \App\Http\Controllers\Admin\User\ImpersonateController::class)->name('get.impersonate.start');
        Route::get('/leave', \App\Http\Controllers\Admin\User\LeaveImpersonationController::class)->name('get.impersonate.leave');
    });


    Route::group(['prefix' => 'admin', 'middleware' => 'user_is_admin'], function () {

        Route::prefix('dashboard')->group(function () {
            Route::get('/', \App\Http\Controllers\DashboardController::class)->name('get.admin.dashboard.index');
        });

    });
});


