<?php

namespace App\Src\Survey\Action;

use App\Src\Survey\Model\Survey;

class DeleteSurveyAction
{
    public function handle(Survey $survey): Survey
    {

        $survey->delete();

        return $survey;
    }
}
