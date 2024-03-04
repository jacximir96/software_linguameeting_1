<?php

namespace App\Src\CourseDomain\Section\Exception;

class InstructorAlreadyAssigned extends \Exception
{
    public function jsonResponse(): array
    {
        return [
            'message' => trans('section.error.on_update'),
            'errors' => [
                'instructor_id' => [
                    trans('section.error.instructor.already_assigned_as_assistant'),
                ],
            ],
        ];
    }
}
