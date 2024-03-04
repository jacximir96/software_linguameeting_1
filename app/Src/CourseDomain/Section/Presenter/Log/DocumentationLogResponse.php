<?php

namespace App\Src\CourseDomain\Section\Presenter\Log;

use Illuminate\Support\Collection;

class DocumentationLogResponse
{
    private Collection $records;

    public function __construct(Collection $records)
    {

        $this->records = $records;
    }

    public function records(): Collection
    {
        return $this->records;
    }
}
