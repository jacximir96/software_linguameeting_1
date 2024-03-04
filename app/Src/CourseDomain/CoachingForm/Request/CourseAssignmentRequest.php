<?php

namespace App\Src\CourseDomain\CoachingForm\Request;

use App\Src\CourseDomain\CoachingForm\Rule\AssignmentsFileSizeRule;
use App\Src\CourseDomain\Section\Model\Section;
use Illuminate\Foundation\Http\FormRequest;

class CourseAssignmentRequest extends FormRequest
{
    private $experienceSelectedInPrevStep = false;

    public function setExperienceSelectedInPrevStep(bool $value)
    {
        $this->experienceSelectedInPrevStep = $value;
    }

    public function isExperienceSelectedInPrevStep(): bool
    {
        return $this->experienceSelectedInPrevStep;
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->hasUploadAssignmentSelected()) {
            return ['guide_type' => [new AssignmentsFileSizeRule($this)]];
        }

        return [];
    }

    public function messages()
    {
        return [];
    }

    public function hasGuideSelected(): bool
    {
        return $this->guide_type == 'guide';
    }

    public function hasUploadAssignmentSelected(): bool
    {
        return $this->guide_type == 'file';
    }

    public function hasAssignmentForAllSession(Section $section): bool
    {
        return $this->filled('assignment_for_all_'.$section->id);
    }

    public function hasSessionsInWeeks(): bool
    {
        return $this->week_type == 'week';
    }

    //key can be weekId or session_order
    public function existsChapterIdKey(int $key)
    {
        return isset($this->chapter_id[$key]);
    }

    public function obtainChapterId(int $key)
    {
        return $this->chapter_id[$key];
    }

    public function existsStudentsAccessIdKey(int $key)
    {
        return isset($this->chapter_id[$key]);
    }

    public function canStudentAccess(int $key): bool
    {
        return (bool) $this->students_access[$key];
    }

    public function existsInstructions(int $key)
    {
        return isset($this->instructions[$key]);
    }

    public function obtainInstructions(int $key): string
    {
        if (! $this->existsInstructions($key)) {
            return '';
        }

        return $this->instructions[$key];
    }

    public function existsInstructionsStudents(int $key)
    {
        return isset($this->instructions_students[$key]);
    }

    public function obtainInstructionsStudents(int $key): string
    {
        if (! $this->existsInstructionsStudents($key)) {
            return '';
        }

        return $this->instructions_students[$key];
    }

    public function isSaveForAllSessions(): bool
    {
        return $this->target == 'all';
    }
}
