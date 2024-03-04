<?php

namespace App\Src\InstructorDomain\Students\Presenter;

use App\Src\ActivityLog\Repository\StudentActivityRepository;
use App\Src\CourseDomain\Course\Repository\CourseInstructorRepository;
use App\Src\CourseDomain\SessionDomain\StudentReview\Repository\StudentReviewRepository;
use App\Src\CourseDomain\SessionDomain\StudentReview\Service\Grade;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\NumericGrade;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Service\RubricBuilder;
use App\Src\Shared\Model\ValueObject\Id;
use App\Src\Shared\Service\IdCollection;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;


class ShowEnrollmentPresenter
{
    //construct
    private CourseInstructorRepository $courseInstructorRepository;

    private StudentReviewRepository $studentReviewRepository;

    private StudentActivityRepository $studentActivityRepository;

    private RubricBuilder $rubricBuilder;

    //status
    private User $instructor;
    private Collection $instructorCourses;

    public function __construct(CourseInstructorRepository $courseInstructorRepository,
                                StudentReviewRepository $studentReviewRepository,
                                StudentActivityRepository $studentActivityRepository,
                                RubricBuilder $rubricBuilder)
    {
        $this->courseInstructorRepository = $courseInstructorRepository;
        $this->studentReviewRepository = $studentReviewRepository;
        $this->studentActivityRepository = $studentActivityRepository;
        $this->rubricBuilder = $rubricBuilder;

        $this->instructorCourses = collect();

    }

    public function handle(Enrollment $enrollment): ShowEnrollmentResponse
    {

        $enrollmentSessions = $enrollment->enrollmentSession->sortBy(function ($enrollmentSession){
            return $enrollmentSession->scheduleSession()->start()->toDatetimeString();
        });

        $rubric = $this->rubricBuilder->buildForInstructor();

        $lastLogin = $this->studentActivityRepository->obtainLastLogin($enrollment->user);

        return new ShowEnrollmentResponse($enrollment, $enrollmentSessions, $rubric, $lastLogin);
    }
}
