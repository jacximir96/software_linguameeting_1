<?php

namespace App\Src\Shared\Presenter\Breadcrumb;

use App\Src\CourseDomain\CoachingForm\Presenter\Breadcrumb\CoachingFormBreadcrumb;
use App\Src\UniversityDomain\University\Presenter\Breadcrumb\CreateBreadcrumb;
use App\Src\UniversityDomain\University\Presenter\Breadcrumb\EditBreadcrumb;
use App\Src\UniversityDomain\University\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\UniversityDomain\University\Presenter\Breadcrumb\ShowBreadcrumb;
use App\Src\UserDomain\User\Presenter\EditProfileBreadcrumb;

class BreadcrumbFactory
{
    private $breadcrumbsMap = [];

    public function __construct()
    {
        $this->breadcrumbsMap = [

            //Coach
            \App\Src\CoachDomain\Coach\Presenter\Breadcrumb\IndexBreadcrumb::SLUG => \App\Src\CoachDomain\Coach\Presenter\Breadcrumb\IndexBreadcrumb::class,
            \App\Src\CoachDomain\Coach\Presenter\Breadcrumb\ShowBreadcrumb::SLUG => \App\Src\CoachDomain\Coach\Presenter\Breadcrumb\ShowBreadcrumb::class,
            \App\Src\CoachDomain\Coach\Presenter\Breadcrumb\EditBreadcrumb::SLUG => \App\Src\CoachDomain\Coach\Presenter\Breadcrumb\EditBreadcrumb::class,
            \App\Src\CoachDomain\Coach\Presenter\Breadcrumb\CreateBreadcrumb::SLUG => \App\Src\CoachDomain\Coach\Presenter\Breadcrumb\CreateBreadcrumb::class,

            //Coach - Ranking
            \App\Src\CoachDomain\Ranking\Presenter\Breadcrumb\IndexBreadcrumb::SLUG => \App\Src\CoachDomain\Ranking\Presenter\Breadcrumb\IndexBreadcrumb::class,

            //Coach - Zoom
            \App\Src\CoachDomain\Zoom\Presenter\Breadcrumb\IndexZoomMeetingBreadcrumb::SLUG => \App\Src\CoachDomain\Zoom\Presenter\Breadcrumb\IndexZoomMeetingBreadcrumb::class,

            //Coaching form
            CoachingFormBreadcrumb::SLUG => CoachingFormBreadcrumb::class,

            //coaching form - experiences
            \App\Src\CourseDomain\CoachingFormExperiences\Presenter\Breadcrumb\CoachingFormBreadcrumb::SLUG => \App\Src\CourseDomain\CoachingFormExperiences\Presenter\Breadcrumb\CoachingFormBreadcrumb::class,

            //config - language
            \App\Src\Localization\Language\Presenter\Breadcrumb\IndexBreadcrumb::SLUG => \App\Src\Localization\Language\Presenter\Breadcrumb\IndexBreadcrumb::class,

            //course
            \App\Src\CourseDomain\Course\Presenter\Breadcrumb\IndexBreadcrumb::SLUG => \App\Src\CourseDomain\Course\Presenter\Breadcrumb\IndexBreadcrumb::class,
            \App\Src\CourseDomain\Course\Presenter\Breadcrumb\ShowBreadcrumb::SLUG => \App\Src\CourseDomain\Course\Presenter\Breadcrumb\ShowBreadcrumb::class,

            //Experience
            \App\Src\ExperienceDomain\Experience\Presenter\Breadcrumb\IndexBreadcrumb::SLUG => \App\Src\ExperienceDomain\Experience\Presenter\Breadcrumb\IndexBreadcrumb::class,
            \App\Src\ExperienceDomain\Experience\Presenter\Breadcrumb\CreateBreadcrumb::SLUG => \App\Src\ExperienceDomain\Experience\Presenter\Breadcrumb\CreateBreadcrumb::class,
            \App\Src\ExperienceDomain\Experience\Presenter\Breadcrumb\EditBreadcrumb::SLUG => \App\Src\ExperienceDomain\Experience\Presenter\Breadcrumb\EditBreadcrumb::class,

            //Guide
            \App\Src\ConversationGuideDomain\Guide\Presenter\Breadcrumb\IndexBreadcrumb::SLUG => \App\Src\ConversationGuideDomain\Guide\Presenter\Breadcrumb\IndexBreadcrumb::class,
            \App\Src\ConversationGuideDomain\Guide\Presenter\Breadcrumb\ShowBreadcrumb::SLUG => \App\Src\ConversationGuideDomain\Guide\Presenter\Breadcrumb\ShowBreadcrumb::class,

            //instructor
            \App\Src\InstructorDomain\Instructor\Presenter\Breadcrumb\IndexBreadcrumb::SLUG => \App\Src\InstructorDomain\Instructor\Presenter\Breadcrumb\IndexBreadcrumb::class,
            \App\Src\InstructorDomain\Instructor\Presenter\Breadcrumb\ShowBreadcrumb::SLUG => \App\Src\InstructorDomain\Instructor\Presenter\Breadcrumb\ShowBreadcrumb::class,
            \App\Src\InstructorDomain\Instructor\Presenter\Breadcrumb\CreateBreadcrumb::SLUG => \App\Src\InstructorDomain\Instructor\Presenter\Breadcrumb\CreateBreadcrumb::class,
            \App\Src\InstructorDomain\Instructor\Presenter\Breadcrumb\EditBreadcrumb::SLUG => \App\Src\InstructorDomain\Instructor\Presenter\Breadcrumb\EditBreadcrumb::class,

            //profile
            EditProfileBreadcrumb::SLUG => EditProfileBreadcrumb::class,

            //Students
            \App\Src\StudentDomain\Student\Presenter\Breadcrumb\IndexBreadcrumb::SLUG => \App\Src\StudentDomain\Student\Presenter\Breadcrumb\IndexBreadcrumb::class,
            \App\Src\StudentDomain\Student\Presenter\Breadcrumb\ShowBreadcrumb::SLUG => \App\Src\StudentDomain\Student\Presenter\Breadcrumb\ShowBreadcrumb::class,
            \App\Src\StudentDomain\Student\Presenter\Breadcrumb\EditBreadcrumb::SLUG => \App\Src\StudentDomain\Student\Presenter\Breadcrumb\EditBreadcrumb::class,
            \App\Src\StudentDomain\Student\Presenter\Breadcrumb\CreateBreadcrumb::SLUG => \App\Src\StudentDomain\Student\Presenter\Breadcrumb\CreateBreadcrumb::class,

            //university
            IndexBreadcrumb::SLUG => IndexBreadcrumb::class,
            CreateBreadcrumb::SLUG => CreateBreadcrumb::class,
            EditBreadcrumb::SLUG => EditBreadcrumb::class,
            ShowBreadcrumb::SLUG => ShowBreadcrumb::class,

            //university - bookstore request
            \App\Src\RegisterCodeDomain\BookstoreRequest\Presenter\Breadcrumb\IndexBreadcrumb::SLUG => \App\Src\RegisterCodeDomain\BookstoreRequest\Presenter\Breadcrumb\IndexBreadcrumb::class,
            \App\Src\RegisterCodeDomain\BookstoreRequest\Presenter\Breadcrumb\CreateBreadcrumb::SLUG => \App\Src\RegisterCodeDomain\BookstoreRequest\Presenter\Breadcrumb\CreateBreadcrumb::class,
            \App\Src\RegisterCodeDomain\BookstoreRequest\Presenter\Breadcrumb\EditBreadcrumb::SLUG => \App\Src\RegisterCodeDomain\BookstoreRequest\Presenter\Breadcrumb\EditBreadcrumb::class,
            \App\Src\RegisterCodeDomain\BookstoreRequest\Presenter\Breadcrumb\ShowBreadcrumb::SLUG => \App\Src\RegisterCodeDomain\BookstoreRequest\Presenter\Breadcrumb\ShowBreadcrumb::class,

            //university - bookstore codes
            \App\Src\RegisterCodeDomain\RegisterCode\Presenter\Breadcrumb\SearchBreadcrumb::SLUG => \App\Src\RegisterCodeDomain\RegisterCode\Presenter\Breadcrumb\SearchBreadcrumb::class,

        ];
    }

    public function build(string $type): ?Breadcrumb
    {
        if (isset($this->breadcrumbsMap[$type])) {
            $presenter = app($this->breadcrumbsMap[$type]);

            return $presenter->handle();
        }

        return null;
    }
}
