<?php

namespace App\Src\CourseDomain\Course\Service\Routes;

use App\Src\Shared\Model\ValueObject\Url;

interface Routes
{
    public function editUrl(): Url;

    public function downloadSummary(): Url;
}
