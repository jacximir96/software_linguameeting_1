<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Form;

use App\Src\CourseDomain\CoachingForm\Service\Wizard\Wizard;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AcademicDatesCreateForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

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
        return json_encode($this->holidays);
    }

    public function holidaysAsCarbonCollect(): Collection
    {
        $holidays = collect();

        foreach ($this->holidays as $holiday) {
            $holiday = Carbon::parse($holiday);

            $holidays->push($holiday);
        }

        return $holidays->sort();
    }

    public function config(Wizard $wizard)
    {
        $this->action = route('post.admin.course.coaching_form.create.academic_dates');

        $this->model = $wizard->get();

        $this->holidays = $wizard->holidays();

        $this->semesterOptions = $this->fieldFormBuilder->obtainSemesterOptions();

        $this->yearsOptions = $this->fieldFormBuilder->obtainNumberOptions(Carbon::now()->year, Carbon::now()->year + 1);

        $this->experiencesOptions = $this->fieldFormBuilder->obtainExperiencesOptions();
    }
}
