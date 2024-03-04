<?php

namespace App\Src\UniversityDomain\Instructor\Rule;

use App\Src\UniversityDomain\Instructor\Repository\UniversityInstructorRepository;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UniversityUniqueRule implements Rule
{
    private FormRequest $request;

    private UniversityInstructorRepository $universityInstructorRepository;

    public function __construct(FormRequest $request, UniversityInstructorRepository $universityInstructorRepository)
    {
        $this->request = $request;

        $this->universityInstructorRepository = $universityInstructorRepository;
    }

    public function passes($attribute, $value)
    {
        $universityId = $value;
        $instructorId = $this->request->instructor->id;

        $exists = $this->universityInstructorRepository->obtainUniversityAndInstructorOrNull($universityId, $instructorId);

        if ($exists) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'The instructor and the university are already related.';
    }
}
