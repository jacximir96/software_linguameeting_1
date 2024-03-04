<?php

namespace App\Src\InstructorDomain\Instructor\Presenter;

use Illuminate\Support\Collection;

class TeacherAssistantResponse
{
    private CommonResponse $commonResponse;

    private Collection $courses;

    private Collection $sectionsAsTeachingAssistant;

    public function __construct(CommonResponse $commonResponse, Collection $courses, Collection $sectionsAsTeachingAssistant)
    {
        $this->commonResponse = $commonResponse;
        $this->courses = $courses;
        $this->sectionsAsTeachingAssistant = $sectionsAsTeachingAssistant;
    }

    public function commonResponse(): CommonResponse
    {
        return $this->commonResponse;
    }

    public function courses(): Collection
    {
        return $this->courses;
    }

    public function hasCourses(): bool
    {
        return (bool) $this->courses->count();
    }

    public function sectionsAsTeachingAssistant(): Collection
    {
        return $this->sectionsAsTeachingAssistant;
    }

    public function hasSectionsAsTeachingAssistant(): bool
    {
        return (bool) $this->sectionsAsTeachingAssistant->count();
    }
}
