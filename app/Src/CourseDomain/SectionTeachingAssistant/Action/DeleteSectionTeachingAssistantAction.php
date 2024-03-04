<?php

namespace App\Src\CourseDomain\SectionTeachingAssistant\Action;

use App\Src\CourseDomain\SectionTeachingAssistant\Model\SectionTeachingAssistant;

class DeleteSectionTeachingAssistantAction
{
    public function handle(SectionTeachingAssistant $sectionTeachingAssistant)
    {
        $sectionTeachingAssistant->delete();
    }
}
