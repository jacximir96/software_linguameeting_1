<?php

namespace App\Src\CourseDomain\Schedule\Presenter;

use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;

class SessionSection
{
    private \App\Src\CourseDomain\Section\Model\Section $section;

    private Collection $students;

    public function __construct(\App\Src\CourseDomain\Section\Model\Section $section)
    {

        $this->section = $section;

        $this->students = collect();
    }

    public function section(): \App\Src\CourseDomain\Section\Model\Section
    {
        return $this->section;
    }

    public function students(): Collection
    {
        return $this->students;
    }

    public function addStudent(User $student)
    {
        $this->students->push($student);
    }

    public function studentSorted(): Collection
    {
        return $this->students->sortBy(function ($student) {
            return $student->writeFullName();
        });
    }
}
