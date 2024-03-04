<?php
namespace App\Http\Controllers\Coach\Feedback\Manager;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\FeedbackDomain\ManagerEvaluation\Presenter\Breadcrumb\Coach\IndexBreadcrumb;
use App\Src\CoachDomain\FeedbackDomain\ManagerEvaluation\Repository\ManagerEvaluationRepository;

class IndexController extends Controller
{
    use Breadcrumable;

    private ManagerEvaluationRepository $managerEvaluationRepository;

    public function __construct (ManagerEvaluationRepository $managerEvaluationRepository){

        $this->managerEvaluationRepository = $managerEvaluationRepository;
    }

    public function __invoke()
    {
        $coach = user();

        $evaluations = $this->managerEvaluationRepository->obtainFromCoach($coach);

        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'coach' => $coach,
            'evaluations' => $evaluations,
            'timezone' => $coach->timezone,
        ]);

        return view('coach.feedback.manager.index');
    }
}
