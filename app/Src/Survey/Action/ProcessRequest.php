<?php

namespace App\Src\Survey\Action;

use App\Src\Survey\Model\Survey;
use App\Src\Survey\Request\SurveyRequest;

class ProcessRequest
{
    public function handle(SurveyRequest $request, Survey $survey): Survey
    {

        $survey->description = $request->description;
        $survey->active = (bool) $request->active;
        $survey->url = $request->url;
        $survey->observations = $request->observations ?? '';

        $survey->save();

        return $survey;
    }
}
