<?php

namespace App\Src\CourseDomain\SectionTeachingAssistant\Exception;

class TeachingAssistantExistsInSection extends \Exception
{
    public function jsonResponse(): array
    {
        return [
            'message' => trans('section.error.on_update'),
            'errors' => [
                'teaching_assistant_id' => [
                    trans('section.error.teaching_assistant.exists'),
                ],
            ],
        ];
    }
}
