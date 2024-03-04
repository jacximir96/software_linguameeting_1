<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter;

use App\Src\CourseDomain\CoachingForm\Service\Wizard\Form\OneOnOneFormForAll;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Form\OneOnOneWeekForm;
use App\Src\CourseDomain\Course\Model\Course;
use Illuminate\Support\Collection;

class OneOnOneWeekResponse
{
    use SectionOpenable;

    private Course $course;

    private Collection $sections;

    private Collection $coachingWeeks;

    private Collection $chaptersOptions;

    private OneOnOneWeekForm $oneOnOneWeekForm;

    private OneOnOneFormForAll $oneOnOneFormForAll;

    public function __construct(Course $course, Collection $sections, Collection $coachingWeeks, Collection $chaptersOptions, OneOnOneWeekForm $oneOnOneWeekForm, OneOnOneFormForAll $oneOnOneFormForAll)
    {

        $this->course = $course;
        $this->sections = $sections;
        $this->coachingWeeks = $coachingWeeks;
        $this->chaptersOptions = $chaptersOptions;
        $this->oneOnOneWeekForm = $oneOnOneWeekForm;
        $this->oneOnOneFormForAll = $oneOnOneFormForAll;
    }

    public function course(): Course
    {
        return $this->course;
    }

    public function sections(): Collection
    {
        return $this->sections;
    }

    public function coachingWeeks(): Collection
    {
        return $this->coachingWeeks;
    }

    public function chaptersOptions(): Collection
    {
        return $this->chaptersOptions;
    }

    public function form(): OneOnOneWeekForm
    {
        return $this->oneOnOneWeekForm;
    }

    public function formForAll(): OneOnOneFormForAll
    {
        return $this->oneOnOneFormForAll;
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
