<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter;

use App\Src\CourseDomain\CoachingForm\Service\Wizard\Form\OneOnOneFlexForm;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Form\OneOnOneFormForAll;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Flex\Service\FlexSessions;
use App\Src\CourseDomain\Section\Model\Section;
use Illuminate\Support\Collection;

class OneOnOneFlexResponse
{
    use SectionOpenable;

    private Course $course;

    private Collection $sections;

    private FlexSessions $flexSessions;

    private Collection $chaptersOptions;

    private OneOnOneFlexForm $oneOnOneFlexForm;

    private OneOnOneFormForAll $oneOnOneFormForAll;

    public function __construct(Course $course,
        Collection $sections,
        FlexSessions $flexSessions,
        Collection $chaptersOptions,
        OneOnOneFlexForm $oneOnOneFlexForm,
        OneOnOneFormForAll $oneOnOneFormForAll)
    {
        $this->course = $course;
        $this->sections = $sections;
        $this->flexSessions = $flexSessions;
        $this->chaptersOptions = $chaptersOptions;
        $this->oneOnOneFlexForm = $oneOnOneFlexForm;
        $this->oneOnOneFormForAll = $oneOnOneFormForAll;
    }

    public function sections(): Collection
    {
        return $this->sections;
    }

    public function flexSessions(): FlexSessions
    {
        return $this->flexSessions;
    }

    public function chaptersOptions(): Collection
    {
        return $this->chaptersOptions;
    }

    public function form(): OneOnOneFlexForm
    {
        return $this->oneOnOneFlexForm;
    }

    public function formForAll(): OneOnOneFormForAll
    {
        return $this->oneOnOneFormForAll;
    }

    public function hasGuideSelected(): bool
    {
        return true;
    }

    public function hasUploadAssigmentSelected(): bool
    {
        return ! $this->hasGuideSelected();
    }

    public function courseIsLingroAndHasBook(): bool
    {
        if ($this->course->isLingro()) {
            if ($this->course->conversationGuide->hasBook()) {
                return true;
            }
        }

        return false;
    }

    public function getSectionAssignmentOrNull(Section $section): ?SectionAssignment
    {
        foreach ($this->sections as $sectionAssignment) {
            if ($sectionAssignment->isSameSection($section)) {
                return $sectionAssignment;
            }
        }

        return null;
    }

    public function linguameetingInstructionsUrl(): string
    {
        $urlDropboxKey = 'linguameeting.conversation_guides.external_url.guides.linguameeting.'.$this->course->language->id;

        return config($urlDropboxKey);
    }

    public function hasSectionsToOpen(): bool
    {
        return true;
    }

    public function showApplyToAllSectionsButton(): bool
    {
        return $this->sections->count() > 1;
    }
}
