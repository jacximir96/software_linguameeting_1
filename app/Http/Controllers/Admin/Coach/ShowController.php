<?php

namespace App\Http\Controllers\Admin\Coach;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Coach\Presenter\Breadcrumb\ShowBreadcrumb;
use App\Src\CoachDomain\Coach\Presenter\ShowCoachPresenter;
use App\Src\CoachDomain\Coach\Repository\CoachRepository;
use App\Src\UserDomain\Role\Service\RoleChecker;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;

class ShowController extends Controller
{
    use Breadcrumable;


    private CoachRepository $coachRepository;

    public function __construct (CoachRepository $coachRepository){

        $this->coachRepository = $coachRepository;
    }

    public function __invoke(User $coach)
    {

        $coach->load($this->coachRepository->relationsWithCoachReview());

        $presenter = app(ShowCoachPresenter::class);
        $data = $presenter->handle($coach);

        $this->buildBreadcrumbAndSendToView(ShowBreadcrumb::SLUG);

        $checkerRole = app(RoleChecker::class);

        view()->share([
            'coach' => $coach,
            'checkerRole' => $checkerRole,
            'data' => $data,
            'timezone' => $this->userTimezone()
        ]);

        return view('admin.coach.show');
    }
}
