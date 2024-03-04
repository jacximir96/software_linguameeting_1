<?php
namespace App\Http\Controllers\Admin\Coach\Zoom;


use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Coach\Repository\CoachRepository;
use App\Src\CoachDomain\Zoom\Export\ZoomMeetingExport;
use App\Src\UniversityDomain\Instructor\Request\SearchInstructorRequest;
use Maatwebsite\Excel\Facades\Excel;


class DownloadZoomMeetingExcelController extends Controller
{

    private CoachRepository $coachRepository;

    public function __construct(CoachRepository $coachRepository)
    {
        $this->coachRepository = $coachRepository;
    }

    public function __invoke(SearchInstructorRequest $request)
    {
        $coaches = $this->coachRepository->obtainCoachesForZoomMeetingIndex();

        return Excel::download(new ZoomMeetingExport($coaches), 'zoom_meetings.xlsx');
    }
}
