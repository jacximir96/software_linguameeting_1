<?php

namespace App\Src\CourseDomain\Course\Model;

class StudentsNumber
{
    private int $students;

    private function __construct(int $students)
    {
        $this->students = $students;
    }

    public static function create(int $students): self
    {
        if ($students < 1) {
            throw new \Exception('Students number invalid.');
        }

        return new self($students);
    }

    public function get(): int
    {
        return $this->students;
    }
}
