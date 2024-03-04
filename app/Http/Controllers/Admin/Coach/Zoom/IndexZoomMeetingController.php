<?php

namespace App\Http\Controllers\Admin\Coach\Zoom;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Coach\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\CoachDomain\Coach\Repository\CoachRepository;
use App\Src\CoachDomain\Coach\Service\SearchForm;
use App\Src\Shared\Service\CriteriaSearch;

class IndexZoomMeetingController extends Controller
{
    use Breadcrumable, Orderable;

    private CoachRepository $coachRepository;

    public function __construct(CoachRepository $coachRepository)
    {
        $this->coachRepository = $coachRepository;
    }

    public function __invoke()
    {
        $coaches = $this->coachRepository->obtainCoachesForZoomMeetingIndex();

        $this->buildBreadcrumbAndSendToView(IndexBreadcrumb::SLUG);

        view()->share([
            'coaches' => $coaches,
        ]);

        return view('admin.coach.zoom-meeting.index');
    }
}
