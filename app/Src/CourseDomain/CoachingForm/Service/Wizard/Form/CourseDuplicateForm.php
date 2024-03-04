<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Form;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CourseDuplicateForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private Course $course;

    private User $user;

    private array $semesterOptions = [];

    private array $yearsOptions = [];

    private array $experiencesOptions = [];

    private array $holidays = [];

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function hasHolidays(): bool
    {
        return ! empty($this->holidaysDates);
    }

    public function writeHolidaysForCalendar(): string
    {
        if (! $this->course->holiday->count()) {
            return '[]';
        }

        $holidays = $this->course->holiday
            ->map(function ($holiday) {
                return '"'.$holiday->date->toDateString().'"';
            })
            ->sort()
            ->toArray();

        $holidays = implode(',', $holidays);

        return $holidays;
    }

    public function holidaysAsCarbonCollect(): Collection
    {
        $holidays = collect();

        foreach ($this->course->holiday as $holiday) {
            $holidays->push($holiday->date);
        }

        return $holidays->sort();
    }

    public function config(Course $course, User $user)
    {
        $this->initialize($course, $user);

        $this->configModel($course);

        $this->configDropdownOptions();
    }

    private function initialize(Course $course, User $user)
    {
        $this->course = $course;

        $this->user = $user;

        $this->action = route('post.admin.course.coaching_form.duplicate.course_information', $course);
    }

    private function configModel(Course $course)
    {
        $this->model = $this->course->toArray();

        $this->model['start_date'] = $this->course->start_date->toDateString();
        $this->model['end_date'] = $this->course->end_date->toDateString();

        if ($course->serviceType->hasConversationGuide()){
            $this->model['experience'] = $this->course->conversationPackage->hasExperiences();
        }

        if ($this->course->holiday->count()) {
            $this->configHolidaysDates();
        }
    }

    private function configDropdownOptions()
    {
        $this->semesterOptions = $this->fieldFormBuilder->obtainSemesterOptions();

        $this->yearsOptions = $this->fieldFormBuilder->obtainNumberOptions(Carbon::now()->year, Carbon::now()->year + 1);

        $this->experiencesOptions = $this->fieldFormBuilder->obtainExperiencesOptions();
    }

    private function configHolidaysDates()
    {
        $this->holidays = $this->course->holiday
            ->map(function ($holiday) {
                return $holiday->date->toDateString();
            })
            ->sort()
            ->toArray();
    }
}
