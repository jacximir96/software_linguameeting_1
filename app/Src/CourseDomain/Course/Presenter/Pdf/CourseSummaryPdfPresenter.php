<?php

namespace App\Src\CourseDomain\Course\Presenter\Pdf;

use App\Src\CourseDomain\CoachingForm\Presenter\CourseSummaryCoursePresenter;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Presenter\SummaryFilePresenter;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use Barryvdh\DomPDF\Facade\Pdf;

class CourseSummaryPdfPresenter
{
    public function handle(Course $course): \Barryvdh\DomPDF\PDF
    {
        $presenter = app(SummaryFilePresenter::class);
        $viewData = $presenter->handle($course);
        $courseSummary = app(CourseSummaryCoursePresenter::class, ['course' => $course]);

        $dataBackground = file_get_contents(public_path('assets/img/background_page_pdf.png'));
        $typeBackground = mime_content_type(public_path('assets/img/background_page_pdf.png'));
        $backgroundBase64 = 'data:'.$typeBackground.';base64,'.base64_encode($dataBackground);

        $data = [
            'backgroundBase64' => $backgroundBase64,
            'courseSummary' => $courseSummary,
            'viewData' => $viewData,
            'linguaMoney' => new LinguaMoney(),
            'user' => user(),
        ];

        $pdf = PDF::loadView('admin.course.file.summary.index', $data);

        return $pdf;
    }
}
