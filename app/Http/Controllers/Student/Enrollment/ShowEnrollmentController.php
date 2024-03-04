<?php
namespace App\Http\Controllers\Student\Enrollment;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\Localization\TimeZone\Repository\TimeZoneRepository;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Enrollment\Presenter\StudentRole\ShowEnrollmentFlexPresenter;
use App\Src\StudentDomain\Enrollment\Presenter\StudentRole\ShowEnrollmentWeeksPresenter;
use App\Src\StudentDomain\Enrollment\Presenter\StudentRole\Breadcrumb\EnrollmentBreadcrumb;
use App\Src\StudentDomain\Enrollment\Repository\EnrollmentRepository;
use App\Src\StudentDomain\Makeup\Service\MakeupSearcher;
use App\Src\Survey\Service\SurveyFinder;
use Carbon\Carbon;


class ShowEnrollmentController extends Controller
{
    use Breadcrumable;

    private SurveyFinder $surveyFinder;

    private EnrollmentRepository $enrollmentRepository;

    public function __construct (SurveyFinder $surveyFinder, EnrollmentRepository $enrollmentRepository){
        $this->surveyFinder = $surveyFinder;
        $this->enrollmentRepository = $enrollmentRepository;
    }

    public function __invoke(Enrollment $enrollment)
    {
        $enrollment->load($this->enrollmentRepository->relationshipsWithSession());

        $student = user();

        $nowUTC = Carbon::now($this->userTimezone()->name)->setTimezone('UTC');
        $experienceTimezone = TimeZoneRepository::findByName(config('linguameeting.timezone.by_default_in_experiences'));

        if ($enrollment->course()->isFlex()){
            $presenter = app(ShowEnrollmentFlexPresenter::class);
            $viewData = $presenter->handle($enrollment);
        }
        else{
            $presenter = app(ShowEnrollmentWeeksPresenter::class);
            $viewData = $presenter->handle($enrollment);
        }

        $breadcrumb = new EnrollmentBreadcrumb($enrollment->section->course);
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        $viewSurvey = $this->surveyFinder->findFromCourse($enrollment->course());

        $makeupSearcher = app(MakeupSearcher::class);
        $makeupAvailability = $makeupSearcher->searchFromEnrollment($enrollment);

        view()->share([
            'course' => $enrollment->course(),
            'experienceTimezone' => $experienceTimezone,
            'makeupAvailability' => $makeupAvailability,
            'nowUTC' => $nowUTC,
            'showSurvey' => $enrollment->course()->mustShowSurvey(),
            'student' => $student,
            'timezone' => $this->userTimezone(),
            'viewData' => $viewData,
            'viewSurvey' => $viewSurvey,
        ]);

        return view('student.enrollment.show');
    }
}
