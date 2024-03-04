<?php

namespace App\Http\Controllers\Admin\Coach\Zoom;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Coach\Repository\CoachRepository;
use App\Src\CourseDomain\Course\Model\Course;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;


class DownloadZoomMeetingPdfController extends Controller
{

    private CoachRepository $coachRepository;

    public function __construct(CoachRepository $coachRepository)
    {
        $this->coachRepository = $coachRepository;
    }

    public function __invoke(Course $course)
    {
        try {


            $coaches = $this->coachRepository->obtainCoachesForZoomMeetingIndex();

            $data = ['coaches' => $coaches];
            view()->share($data);

            //return view('admin.coach.zoom-meeting.list_for_pdf');

            $pdf = PDF::loadView('admin.coach.zoom-meeting.list_for_pdf', $data);

            return $pdf->download();
        } catch (\Throwable $exception) {

            Log::error('There is an error in confirmation step', [
                'course' => $course,
                'exception' => $exception,
            ]);

            flash(trans('coaching_form.exception.error_general'))->error();

            return back();
        }
    }
}
