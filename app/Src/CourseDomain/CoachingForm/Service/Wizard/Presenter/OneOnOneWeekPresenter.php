<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter;

use App\Src\CourseDomain\CoachingForm\Service\Wizard\Form\LinguameetingGuideable;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Form\OneOnOneFormForAll;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Form\OneOnOneWeekForm;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Shared\Service\FieldFormBuilder;

class OneOnOneWeekPresenter
{
    use LinguameetingGuideable;

    private array $chaptersOptions = [];

    private FieldFormBuilder $fieldFormBuilder;

    private OneOnOneWeekForm $oneOnOneWeekForm;

    private OneOnOneFormForAll $oneOnOneFormForAll;

    public function __construct(FieldFormBuilder $fieldFormBuilder, OneOnOneWeekForm $oneOnOneWeekForm, OneOnOneFormForAll $oneOnOneFormForAll)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
        $this->oneOnOneWeekForm = $oneOnOneWeekForm;
        $this->oneOnOneFormForAll = $oneOnOneFormForAll;
    }

    public function handle(Course $course): OneOnOneWeekResponse
    {
        $this->initialize();

        $sections = $course->sectionsOrdered();

        $coachingWeeks = $course->coachingWeeksOrderedWithoutMakeUps();

        $this->configChapterOptions($course);

        $this->oneOnOneWeekForm->config($course);

        $this->oneOnOneFormForAll->config();

        return new OneOnOneWeekResponse($course, $sections, $coachingWeeks, collect($this->chaptersOptions), $this->oneOnOneWeekForm, $this->oneOnOneFormForAll);
    }

    private function initialize()
    {
        $this->chaptersOptions = [];
    }

    private function configChapterOptions(Course $course)
    {

        $this->chaptersOptions = $this->fieldFormBuilder->obtainConversationGuideChapters($course->conversationGuide);

        if ($this->shouldWeAssignDefaultLinguameetingGuides($course)) {
            $this->chaptersOptions = $this->obtainLinguameetingGuide();
        }
    }
}
