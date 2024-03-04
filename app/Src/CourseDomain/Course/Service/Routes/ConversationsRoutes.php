<?php

namespace App\Src\CourseDomain\Course\Service\Routes;

use App\Src\Shared\Model\ValueObject\Url;

class ConversationsRoutes implements Routes
{
    private int $id;

    public function __construct(int $id)
    {

        $this->id = $id;
    }

    public function editUrl(): Url
    {
        return new Url(route('get.admin.course.coaching_form.create.update.academic_dates', $this->id));
    }

    public function downloadSummary(): Url
    {
        return new Url(route('get.admin.course.section.coaching_form.file.download_summary', $this->id));
    }
}
