<?php
namespace App\Http\Controllers\Coach\Feedback\Instructor;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\FeedbackDomain\InstructorEvaluation\Repository\InstructorEvaluationRepository;
use App\Src\CoachDomain\FeedbackDomain\InstructorEvaluation\Presenter\Breadcrumb\Coach\IndexBreadcrumb;


class IndexController extends Controller
{
    use Breadcrumable;

    private InstructorEvaluationRepository $instructorEvaluationRepository;

    public function __construct (InstructorEvaluationRepository $instructorEvaluationRepository){

        $this->instructorEvaluationRepository = $instructorEvaluationRepository;
    }

    public function __invoke()
    {
        $coach = user();

        $evaluations = $this->instructorEvaluationRepository->obtainFromCoach($coach);

        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'coach' => $coach,
            'evaluations' => $evaluations,
            'timezone' => $coach->timezone
        ]);

        return view('coach.feedback.instructor.index');
    }
}
