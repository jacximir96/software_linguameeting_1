<?php
namespace App\Src\CourseDomain\SessionDomain\Session\Presenter\Instructor;

use App\Src\CourseDomain\SessionDomain\StudentReview\Service\Grade;
use Illuminate\Support\Collection;


class GradeStats
{
    private Collection $gradeCounts;

    public function __construct()
    {

        $this->gradeCounts = collect();

        $gradeCount = new GradeCount(0);
        $this->gradeCounts->put(0, $gradeCount);

        for ($i = 3; $i <= 10; $i++) {

            $gradeCount = new GradeCount($i);

            $this->gradeCounts->put($i, $gradeCount);
        }
    }

    public function get(): Collection
    {
        return $this->gradeCounts;
    }

    public function addGrade(Grade $grade)
    {

        $value = $grade->total()->get();

        if ( ! $this->gradeCounts->has($value)) {

            $gradeCount = new GradeCount($value);

            $this->gradeCounts->put($value, $gradeCount);
        }

        $gradeCount = $this->gradeCounts->get($value);

        $gradeCount->add();
    }

    public function printLabelsToJson(): string
    {
        $values = [];

        foreach ($this->gradeCounts as $gradeCount) {
            $values[] = $gradeCount->grade();
        }

        return json_encode($values);
    }

    public function printCountToJson(): string
    {
        $values = [];

        foreach ($this->gradeCounts as $gradeCount) {
            $values[] = $gradeCount->count();
        }

        return json_encode($values);
    }
}
