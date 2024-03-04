<?php

namespace App\Http\Controllers\Course\Section;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Service\CourseFiles;
use App\Src\CourseDomain\Section\Model\Section;
use Illuminate\Support\Facades\Log;

class DownloadInstructionsController extends Controller
{
    private CourseFiles $courseFiles;

    public function __construct(CourseFiles $courseFiles)
    {

        $this->courseFiles = $courseFiles;
    }

    public function __invoke(Section $section)
    {
        try {

            $instructionsFile = $this->courseFiles->obtainSectionInstructionsPdf($section);

            return $instructionsFile->download($section->instructionsFilename());

        } catch (\Throwable $exception) {

            Log::error('There is an error when download section instruction file', [
                'section' => $section,
                'exception' => $exception,
            ]);

            flash(trans('coaching_form.exception.error_general'))->error();

            return back();
        }
    }
}
