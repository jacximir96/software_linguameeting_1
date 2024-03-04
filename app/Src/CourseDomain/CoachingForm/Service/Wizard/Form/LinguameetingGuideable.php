<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Form;

use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\CourseDomain\Course\Model\Course;

trait LinguameetingGuideable
{
    protected function shouldWeAssignDefaultLinguameetingGuides(Course $course): bool
    {

        $optionsIsEmpty = empty($this->chaptersOptions);
        $courseHasLingroWihoutGuide = $course->conversationGuide->hasLingroWithoutGuide();

        return $optionsIsEmpty and $courseHasLingroWihoutGuide;
    }

    protected function obtainLinguameetingGuide(): array
    {

        $linguameetingGuide = ConversationGuide::find(ConversationGuide::ID_IS_LINGUAMEETING);

        return $this->fieldFormBuilder->obtainConversationGuideChapters($linguameetingGuide);
    }
}
