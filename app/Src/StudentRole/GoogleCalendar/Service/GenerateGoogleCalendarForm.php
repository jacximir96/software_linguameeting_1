<?php

namespace App\Src\StudentRole\GoogleCalendar\Service;

use App\Src\Shared\Service\BaseSearchForm;

class GenerateGoogleCalendarForm extends BaseSearchForm
{
    public function config()
    {
        $this->action = route('post.student.calendar.google.generate');

        $this->model = [];
    }
}
