<?php

namespace App\Src\CourseDomain\Section\Exception;

class AssistantAlreadyAssignedAsInstructor extends \Exception
{
    public function jsonResponse(): array
    {
        return [
            'message' => trans('section.error.on_update'),
            'errors' => [
                'teaching_assistant_id' => [
                    trans('section.error.teaching_assistant.already_assigned_as_instructor'),
                ],
            ],
        ];
    }
}
