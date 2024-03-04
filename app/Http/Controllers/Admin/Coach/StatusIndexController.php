<?php
namespace App\Http\Controllers\Admin\Coach;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Coach\Presenter\Breadcrumb\StatusIndexBreadcrumb;
use App\Src\CoachDomain\Coach\Repository\CoachRepository;


class StatusIndexController extends Controller
{
    use Breadcrumable, Orderable;

    private CoachRepository $coachRepository;

    public function __construct(CoachRepository $coachRepository)
    {
        $this->coachRepository = $coachRepository;
    }

    public function __invoke()
    {

        $coaches = $this->coachRepository->obtainCoachesToStatusIndex();

        $breadcrumb = new StatusIndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'coaches' => $coaches,
        ]);

        return view('admin.coach.status_index');
    }
}
