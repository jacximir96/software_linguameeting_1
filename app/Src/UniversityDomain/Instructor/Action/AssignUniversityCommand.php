<?php

namespace App\Src\UniversityDomain\Instructor\Action;

use App\Src\UniversityDomain\Instructor\Exception\InstructorExistsInUniversity;
use App\Src\UniversityDomain\Instructor\Model\UniversityInstructor;
use App\Src\UniversityDomain\Instructor\Repository\UniversityInstructorRepository;
use App\Src\UniversityDomain\University\Model\University;
use App\Src\UserDomain\User\Model\User;

class AssignUniversityCommand
{
    private UniversityInstructorRepository $universityInstructorRepository;

    public function __construct(UniversityInstructorRepository $universityInstructorRepository)
    {
        $this->universityInstructorRepository = $universityInstructorRepository;
    }

    public function handle(University $university, User $instructor): UniversityInstructor
    {
        $this->checkInstructorExistsInUniversity($university, $instructor);

        return $this->createRelationship($university, $instructor);
    }

    private function checkInstructorExistsInUniversity(University $university, User $instructor)
    {
        $relationship = $this->universityInstructorRepository->obtainUniversityAndInstructorOrNull($university->id, $instructor->id);

        if ($relationship) {
            throw new InstructorExistsInUniversity();
        }
    }

    private function createRelationship(University $university, User $instructor)
    {
        $item = new UniversityInstructor();
        $item->university_id = $university->id;
        $item->instructor_id = $instructor->id;
        $item->save();

        return $item;
    }
}
