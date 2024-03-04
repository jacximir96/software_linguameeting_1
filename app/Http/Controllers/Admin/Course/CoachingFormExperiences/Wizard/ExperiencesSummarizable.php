<?php
namespace App\Http\Controllers\Admin\Course\CoachingFormExperiences\Wizard;

use App\Src\CourseDomain\CoachingFormExperiences\Presenter\CourseSummaryCoursePresenter;
use App\Src\CourseDomain\CoachingFormExperiences\Presenter\CourseSummaryUniversityPresenter;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\UniversityDomain\University\Model\University;


trait ExperiencesSummarizable
{

    public function buildCourseSummaryFromUniversity(University $university)
    {
        $courseSummary = app(CourseSummaryUniversityPresenter::class, ['university' => $university]);

        view()->share(['courseSummary' => $courseSummary]);
    }


    public function buildCourseSummaryFromCourse(Course $course)
    {
        $courseSummary = app(CourseSummaryCoursePresenter::class, ['course' => $course]);

        view()->share(['courseSummary' => $courseSummary]);
    }
}
