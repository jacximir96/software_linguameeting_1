<?php

namespace App\Src\Survey\Action;

use App\Src\Survey\Model\Survey;
use App\Src\Survey\Request\SurveyRequest;

class CreateSurveyAction
{
    private ProcessRequest $processRequest;

    public function __construct(ProcessRequest $processRequest)
    {
        $this->processRequest = $processRequest;
    }

    public function handle(SurveyRequest $request, string $type, int $id): Survey
    {

        $survey = new Survey();
        $survey->surveyable_type = $type;
        $survey->surveyable_id = $id;

        return $this->processRequest->handle($request, $survey);
    }
}
