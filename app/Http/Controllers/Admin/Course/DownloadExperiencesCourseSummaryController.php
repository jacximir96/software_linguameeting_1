<?php

namespace App\Http\Controllers\Admin\Course;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Service\CourseFiles;
use Illuminate\Support\Facades\Log;

class DownloadExperiencesCourseSummaryController extends Controller
{
    private CourseFiles $courseFiles;

    public function __construct(CourseFiles $courseFiles)
    {

        $this->courseFiles = $courseFiles;
    }

    public function __invoke(Course $course)
    {
        try {

            $summaryFile = $this->courseFiles->obtainCourseSummaryPdf($course);

            return $summaryFile->download($course->summaryFilename());

        } catch (\Throwable $exception) {

            Log::error('There is an error when download summary experiences course file', [
                'course' => $course,
                'exception' => $exception,
            ]);

            flash(trans('coaching_form.exception.error_general'))->error();

            return back();
        }
    }
}
