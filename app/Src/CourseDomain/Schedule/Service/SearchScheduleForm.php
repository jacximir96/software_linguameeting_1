<?php

namespace App\Src\CourseDomain\Schedule\Service;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\TimeDomain\Date\Service\Periods;
use Carbon\Carbon;

class SearchScheduleForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $periodsOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
        $this->periodsOptions = [];
    }

    public function fieldWithOptions(string $field): array
    {
        return $this->$field;
    }

    public function hasPeriodsOptions(): bool
    {
        return count($this->periodsOptions);
    }

    public function periodKey(): string
    {
        return $this->model['period'] ?? '';
    }

    public function config(Course $course, Periods $periods)
    {
        $this->initialize();

        $this->action = route('post.admin.course.schedule.search', $course->id);

        $this->periodsOptions = $periods->convertToOptions();

        $this->setPeriodByDefault($periods);
    }

    private function initialize()
    {

        $this->isEdit = true;
        $this->periodsOptions = [];
        $this->model = [];
    }

    private function setPeriodByDefault(Periods $periods)
    {
        $current = $periods->nearToDate(Carbon::now());

        if (request()->has('period')) {
            $this->model['period'] = request()->period;
        } elseif ($current) {
            $this->model['period'] = $current->key();
        } else {
            $first = $periods->get()->first();

            if ($first) {
                $this->model['period'] = $first->key();
            }
        }
    }
}
