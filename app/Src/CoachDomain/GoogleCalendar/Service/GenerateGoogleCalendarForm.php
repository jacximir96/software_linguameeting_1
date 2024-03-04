<?php

namespace App\Src\CoachDomain\GoogleCalendar\Service;

use App\Src\Shared\Service\BaseSearchForm;

class GenerateGoogleCalendarForm extends BaseSearchForm
{
    public function config()
    {
        $this->action = route('post.coach.calendar.google.generate');

        $this->model = [];
    }
}
