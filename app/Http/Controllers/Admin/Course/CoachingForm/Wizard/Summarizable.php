<?php

namespace App\Http\Controllers\Admin\Course\CoachingForm\Wizard;

use App\Src\CourseDomain\CoachingForm\Presenter\CourseSummaryCoursePresenter;
use App\Src\CourseDomain\CoachingForm\Presenter\CourseSummaryWizardPresenter;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Wizard;
use App\Src\CourseDomain\Course\Model\Course;

trait Summarizable
{
    public function buildCourseSummaryFromWizard(Wizard $wizard)
    {
        $courseSummary = app(CourseSummaryWizardPresenter::class, ['wizard' => $wizard]);

        view()->share(['courseSummary' => $courseSummary]);
    }

    public function buildCourseSummaryFromCourse(Course $course)
    {
        $courseSummary = app(CourseSummaryCoursePresenter::class, ['course' => $course]);

        view()->share(['courseSummary' => $courseSummary]);
    }
}
