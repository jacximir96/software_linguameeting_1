<?php

namespace App\Http\Controllers\Student\Session\ExtraSession;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Student\Session\Book\BookableController;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Repository\CoachReviewRepository;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReviewOption\Repository\CoachReviewOptionRepository;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Repository\EnrollmentSessionRepository;
use App\Src\CourseDomain\SessionDomain\Session\Exception\SessionOrderIsInvalid;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrderPeriodBuilder;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\StudentDomain\Enrollment\Exception\EnrollmentDoesntExtraSession;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\ExtraSession\Model\ExtraSession;
use App\Src\StudentDomain\ExtraSession\Presenter\Breadcrumb\UseExtraSessionBreadcrumb;
use App\Src\StudentDomain\ExtraSession\Repository\ExtraSessionRepository;
use App\Src\StudentDomain\ExtraSession\Service\SearchCoachForm;
use Illuminate\Support\Facades\Log;


//muestra primera vista
class ShowSearchFormController extends Controller
{
    use Breadcrumable, BookableController, ExtraSessionable;

    private CoachReviewRepository $coachReviewRepository;

    private CoachReviewOptionRepository $coachReviewOptionRepository;

    private CourseRepository $courseRepository;

    private SessionOrderPeriodBuilder $sessionOrderPeriodBuilder;

    private EnrollmentSessionRepository $enrollmentSessionRepository;

    private ExtraSessionRepository $extraSessionRepository;


    public function __construct (CoachReviewRepository $coachReviewRepository,
                                 CoachReviewOptionRepository $coachReviewOptionRepository,
                                 CourseRepository $courseRepository,
                                 SessionOrderPeriodBuilder $sessionOrderPeriodBuilder,
                                 EnrollmentSessionRepository $enrollmentSessionRepository,



                                 ExtraSessionRepository $extraSessionRepository){
        $this->coachReviewRepository = $coachReviewRepository;
        $this->coachReviewOptionRepository = $coachReviewOptionRepository;
        $this->courseRepository = $courseRepository;
        $this->sessionOrderPeriodBuilder = $sessionOrderPeriodBuilder;
        $this->enrollmentSessionRepository = $enrollmentSessionRepository;
        $this->extraSessionRepository = $extraSessionRepository;
    }

    public function __invoke(Enrollment $enrollment, int $sessionOrder)
    {
        try {

            $this->checkSessionOrderIsValid($enrollment, $sessionOrder);

            $extraSession = $this->obtainExtraSession($enrollment);
            $sessionOrder = new SessionOrder($sessionOrder);

            $this->configSession($enrollment, $extraSession);

            $course = $enrollment->course();
            $course->load($this->courseRepository->relations());

            $breadcrumb = new UseExtraSessionBreadcrumb($enrollment);
            $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

            if ($course->isFlex()){
                $searchCoachForm = app(SearchCoachForm::class);
                $searchCoachForm->configForSelectView($enrollment, $sessionOrder);
            }
            else{

                $coachingWeeks = $course->coachingWeeksOrderedWithoutMakeUps()->filter(function ($coachingWeek){
                    return !$coachingWeek->isPast();
                });

                $searchCoachForm = app(SearchCoachForm::class);
                $searchCoachForm->configForSelectView($enrollment, $sessionOrder);

                view()->share(['coachingWeeks' => $coachingWeeks,]);
            }

            view()->share([
                'course' => $course,
                'enrollment' => $enrollment,
                'searchCoachForm' => $searchCoachForm,
                'utcTimezoneName' => TimeZone::TIMEZONE_UTC,
                'userTimezone' => $this->userTimezone(),
            ]);

            return view('student.enrollment.session.extra-session.use_extra_session');

        }
        catch (SessionOrderIsInvalid $exception){

            flash('Session order parameter is incorrect.')->error();
            return redirect()->route('get.student.enrollment.show', $enrollment->hashId());
        }
        catch (EnrollmentDoesntExtraSession $exception ){
            flash('You do not have Extra Sessions available to use.')->error();
            return back();

        }
        catch (\Throwable $exception) {



            Log::error('There is an error when show info to create makeup in no booked session.', [
                'enrollment' => $enrollment,
                'exception' => $exception,
            ]);

            flash('Lo sentimos, pero se ha producido un error creando el Make-up.')->error();

            return back()->withInput();
        }
    }


    private function obtainExtraSession (Enrollment $enrollment):ExtraSession{

        $extraSession = $this->extraSessionRepository->obtainFirstAvailableFromEnrollment($enrollment);

        if ($extraSession){
            return $extraSession;
        }

        throw new EnrollmentDoesntExtraSession();

    }

    private function configSession (Enrollment $enrollment, ExtraSession $extraSession){

        $this->cleanSession();

        $isExtraSession = [
            'enrollment_id' => $enrollment->hashId(),
            'session_order' => $extraSession->hashId(),
        ];

        session()->put('isExtraSession', $isExtraSession);
    }
}
