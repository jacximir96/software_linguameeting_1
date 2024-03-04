<?php

namespace App\Src\Shared\Service;

class OrderListing
{
    private $field = '';

    private $direction = '';

    public function __construct(string $defaultField, string $defaultDirection = 'asc')
    {
        $this->field = $defaultField;

        $this->direction = $defaultDirection;
    }

    public function configFromRequest()
    {
        if (request()->has('sortBy')) {
            $this->field = request()->sortBy;
        }

        if (request()->has('sortDirection')) {
            $this->direction = request()->sortDirection;
        }
    }

    public function field(): string
    {
        return $this->field;
    }

    public function isField(string $field): bool
    {
        return $this->field == $field;
    }

    public function direction(): string
    {
        return $this->direction;
    }

    public function nextDirection(string $fieldToEvaluate): string
    {
        if ($fieldToEvaluate == $this->field) {
            if ($this->direction == 'asc') {
                return 'desc';
            }
        }

        return 'asc';
    }

    public function nextDirectionIsAsc(string $fieldToEvaluate): bool
    {
        return $this->nextDirection($fieldToEvaluate) == 'asc';
    }

    public function searchByField(string $field): bool
    {
        if (! request()->has('sortBy')) {
            if ($field == $this->field) {
                return true;
            }

            return false;
        }

        return $field == $this->field;
    }

    public function isAsc(): bool
    {
        return $this->direction == 'asc';
    }

    public function isDesc(): bool
    {
        return $this->direction == 'desc';
    }
}
