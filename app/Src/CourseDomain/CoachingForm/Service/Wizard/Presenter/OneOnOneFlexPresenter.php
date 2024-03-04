<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter;

use App\Src\CourseDomain\CoachingForm\Service\Wizard\Form\LinguameetingGuideable;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Form\OneOnOneFlexForm;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Form\OneOnOneFormForAll;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Shared\Service\FieldFormBuilder;

class OneOnOneFlexPresenter
{
    use LinguameetingGuideable;

    private array $chaptersOptions = [];

    private FieldFormBuilder $fieldFormBuilder;

    private OneOnOneFlexForm $oneOnOneFlexForm;

    private OneOnOneFormForAll $oneOnOneFormForAll;

    public function __construct(FieldFormBuilder $fieldFormBuilder, OneOnOneFlexForm $oneOnOneFlexForm, OneOnOneFormForAll $oneOnOneFormForAll)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
        $this->oneOnOneFlexForm = $oneOnOneFlexForm;
        $this->oneOnOneFormForAll = $oneOnOneFormForAll;
    }

    public function handle(Course $course): OneOnOneFlexResponse
    {
        $this->initialize();

        $sections = $course->sectionsOrdered();

        $flexSessions = $course->obtainFlexSessions();

        $this->configChapterOptions($course);

        $this->oneOnOneFlexForm->config($course);

        $this->oneOnOneFormForAll->config();

        return new OneOnOneFlexResponse($course, $sections, $flexSessions, collect($this->chaptersOptions), $this->oneOnOneFlexForm, $this->oneOnOneFormForAll);
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
