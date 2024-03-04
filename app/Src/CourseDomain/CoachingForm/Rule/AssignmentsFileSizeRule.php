<?php

namespace App\Src\CourseDomain\CoachingForm\Rule;

use App\Src\CourseDomain\CoachingForm\Request\CourseAssignmentRequest;
use Illuminate\Contracts\Validation\Rule;

class AssignmentsFileSizeRule implements Rule
{
    private CourseAssignmentRequest $request;

    public function __construct(CourseAssignmentRequest $request)
    {
        $this->request = $request;
    }

    public function passes($attribute, $value)
    {
        $totalSizeInBytes = 0;

        foreach ($this->request->assignment as $weekId => $file) {
            if ($this->hasFileSelected($file)) {
                $totalSizeInBytes += $file->getSize();
            }
        }

        $totalSizeInKB = $totalSizeInBytes / 1024;

        if ($totalSizeInKB > config('linguameeting.files.max_upload_size_in_KB')) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return trans('coaching_form.filesize_exceeded');
    }

    private function hasFileSelected($file): bool
    {
        return ! is_null($file);
    }
}
