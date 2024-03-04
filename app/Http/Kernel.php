<?php

namespace App\Http;

use App\Http\Middleware\NoCacheMiddleware;
use App\Src\CoachDomain\FeedbackDomain\Middleware\EvaluationIsFromCoach;
use App\Src\CourseDomain\CoachingForm\Middleware\UserCanHandleCoachinForm;
use App\Src\CourseDomain\SessionDomain\Session\Middleware\SessionCoachIsOwner;
use App\Src\CourseDomain\SessionDomain\StudentReview\Middleware\CanUpdateStudentReview;
use App\Src\ExperienceDomain\Experience\Middleware\CreatePrivateTipMiddleware;
use App\Src\MessagingDomain\Participant\Middleware\UserIsParticipantInThread;
use App\Src\UserDomain\User\Middleware\UserIsAdmin;
use App\Src\UserDomain\User\Middleware\UserIsCoach;
use App\Src\UserDomain\User\Middleware\UserIsStudent;
use App\Src\UserDomain\User\Middleware\UserIsInstructor;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        NoCacheMiddleware::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \App\Http\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        'experience.tip.can_create_private' => CreatePrivateTipMiddleware::class,

        'evaluation_is_from_coach' => EvaluationIsFromCoach::class,

        'user_is_coach' => UserIsCoach::class,
        'user_is_student' => UserIsStudent::class,
        'user_is_instructor' => UserIsInstructor::class,
        'user_is_admin' => UserIsAdmin::class,
        'user_is_participant_in_thread' => UserIsParticipantInThread::class,

        'user_can_handle_coaching_form' => UserCanHandleCoachinForm::class,

        'student_review.can_update' => CanUpdateStudentReview::class,
        'session.coach.is_owner' => SessionCoachIsOwner::class,
    ];
}
