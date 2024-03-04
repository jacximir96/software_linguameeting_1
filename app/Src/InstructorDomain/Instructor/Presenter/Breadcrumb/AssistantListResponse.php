<?php

namespace App\Src\InstructorDomain\Instructor\Presenter\Breadcrumb;

use Illuminate\Support\Collection;

class AssistantListResponse
{
    private Collection $assistantsItems;

    public function __construct(Collection $assistantsItems)
    {

        $this->assistantsItems = $assistantsItems;
    }

    public function assistantsItems(): Collection
    {
        return $this->assistantsItems;
    }
}
