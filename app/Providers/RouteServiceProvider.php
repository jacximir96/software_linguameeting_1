<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/admin/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            $this->mapApiRoutes();

            $this->mapAdminRoutes();

            $this->mapCalendarRoutes();

            $this->mapCoachRoutes();

            $this->mapInstructorRoutes();

            $this->mapCommonRoutes();

            $this->mapStudentRoutes();

        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    protected function mapApiRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->prefix('/admin')
            ->group(base_path('routes/admin/api.php'));
    }

    private function mapAdminRoutes(){

        $this->mapAdminCoachingBillingRoutes();

        $this->mapAdminCoachesRoutes();

        $this->mapAdminCoachingFormRoutes();

        $this->mapAdminCoachingFormExperiencesRoutes();

        $this->mapAdminConfigRoutes();

        $this->mapAdminConversationGuideRoutes();

        $this->mapAdminCoursesRoutes();

        $this->mapAdminEnrollmentsRoutes();

        $this->mapAdminExperiencesRoutes();

        $this->mapAdminInstructorsRoutes();

        $this->mapAdminStudentsRoutes();

        $this->mapAdminMessageRoutes();

        $this->mapAdminRegisterCodeRoutes();

        $this->mapAdminPayments();

        $this->mapAdminSurveyRoutes();

        $this->mapAdminUniversityRoutes();

        $this->mapAdminUserRoutes();
    }

    protected function mapAdminCoachingBillingRoutes()
    {
        Route::middleware(['web', 'auth', 'user_is_admin'])
            ->prefix('admin')
            ->group(base_path('routes/admin/coaching_billing.php'));
    }

    protected function mapAdminCoachesRoutes()
    {
        Route::middleware(['web', 'auth', 'user_is_admin'])
            ->prefix('/admin')
            ->group(base_path('routes/admin/coaches.php'));
    }

    protected function mapAdminCoachingFormRoutes()
    {
        Route::middleware(['web', 'auth', 'user_can_handle_coaching_form'])
            ->prefix('/admin')
            ->group(base_path('routes/admin/coaching_form.php'));
    }

    protected function mapAdminCoachingFormExperiencesRoutes()
    {
        Route::middleware(['web', 'auth', 'user_can_handle_coaching_form'])
            ->prefix('/admin')
            ->group(base_path('routes/admin/coaching_form_experiences.php'));
    }

    protected function mapAdminConfigRoutes()
    {
        Route::middleware(['web', 'auth', 'user_is_admin'])
            ->prefix('/admin')
            ->group(base_path('routes/admin/config.php'));
    }

    protected function mapAdminConversationGuideRoutes()
    {
        Route::middleware(['web', 'auth', 'user_is_admin'])
            ->prefix('/admin')
            ->group(base_path('routes/admin/conversation_guide.php'));
    }

    protected function mapAdminCoursesRoutes()
    {
        Route::middleware(['web', 'auth', 'user_is_admin'])
            ->prefix('/admin')
            ->group(base_path('routes/admin/courses.php'));
    }

    protected function mapAdminEnrollmentsRoutes()
    {
        Route::middleware(['web', 'auth', 'user_is_admin'])
            ->prefix('/admin')
            ->group(base_path('routes/admin/enrollments.php'));
    }

    protected function mapAdminExperiencesRoutes()
    {
        Route::middleware(['web', 'auth', 'user_is_admin'])
            ->prefix('/admin')
            ->group(base_path('routes/admin/experiences.php'));
    }

    protected function mapAdminInstructorsRoutes()
    {
        Route::middleware(['web', 'auth', 'user_is_admin'])
            ->prefix('/admin')
            ->group(base_path('routes/admin/instructors.php'));
    }

    protected function mapAdminStudentsRoutes()
    {
        Route::middleware(['web', 'auth', 'user_is_admin'])
            ->prefix('/admin')
            ->group(base_path('routes/admin/students.php'));
    }

    protected function mapAdminMessageRoutes()
    {
        Route::middleware(['web', 'auth', 'user_is_admin'])
            ->prefix('/admin')
            ->group(base_path('routes/admin/messaging.php'));
    }

    protected function mapAdminRegisterCodeRoutes()
    {
        Route::middleware(['web', 'auth', 'user_is_admin'])
            ->prefix('/admin')
            ->group(base_path('routes/common/register_code.php'));
    }

    protected function mapAdminPayments()
    {
        Route::middleware(['web', 'auth', 'user_is_admin'])
            ->prefix('/admin')
            ->group(base_path('routes/admin/payment.php'));
    }

    protected function mapAdminSurveyRoutes()
    {
        Route::middleware(['web', 'auth', 'user_is_admin'])
            ->prefix('/admin')
            ->group(base_path('routes/admin/survey.php'));
    }

    protected function mapAdminUniversityRoutes()
    {
        Route::middleware(['web', 'auth', 'user_is_admin'])
            ->prefix('/admin')
            ->group(base_path('routes/admin/university.php'));
    }

    protected function mapAdminUserRoutes()
    {
        Route::middleware(['web', 'auth', 'user_is_admin'])
            ->prefix('/admin')
            ->group(base_path('routes/admin/user.php'));
    }

    //COACHES

    protected function mapCalendarRoutes()
    {
        Route::middleware(['web', 'auth', 'user_is_coach'])
            ->prefix('/calendar')
            ->group(base_path('routes/common/calendar.php'));
    }

    protected function mapCoachRoutes()
    {
        Route::middleware(['web', 'auth', 'verified', 'user_is_coach'])
            ->prefix('/coach')
            ->group(base_path('routes/coach/routes.php'));
    }

    //INSTRUCTORS
    protected function mapInstructorRoutes()
    {
        Route::middleware(['web', 'auth', 'verified', 'user_is_instructor'])
            ->prefix('/instructor')
            ->group(base_path('routes/instructor/routes.php'));
    }

    //COMUNES
    protected function mapCommonRoutes (){

        Route::middleware(['web', 'auth'])->prefix('/coaches')->group(base_path('routes/common/coaches.php'));

        Route::middleware(['web', 'auth'])->prefix('/')->group(base_path('routes/common/conversation_guide.php'));

        Route::middleware(['web', 'auth'])->prefix('course')->group(base_path('routes/common/course.php'));

        Route::middleware(['web', 'auth'])->prefix('/')->group(base_path('routes/common/enrollments.php'));

        Route::middleware(['web', 'auth'])->prefix('/')->group(base_path('routes/common/experiences.php'));

        Route::middleware(['web', 'auth'])->group(base_path('routes/common/messaging.php'));

        Route::middleware(['web', 'auth'])->prefix('/')->group(base_path('routes/common/notification.php'));
    }

    //STUDENTS
    protected function mapStudentRoutes()
    {
        Route::middleware(['web', 'auth', 'user_is_student'])
            ->prefix('/student')
            ->group(base_path('routes/student/routes.php'));
    }

}
