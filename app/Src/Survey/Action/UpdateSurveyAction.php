<?php

namespace App\Src\Survey\Action;

use App\Src\Survey\Model\Survey;
use App\Src\Survey\Request\SurveyRequest;

class UpdateSurveyAction
{
    private ProcessRequest $processRequest;

    public function __construct(ProcessRequest $processRequest)
    {

        $this->processRequest = $processRequest;
    }

    public function handle(SurveyRequest $request, Survey $survey): Survey
    {

        return $this->processRequest->handle($request, $survey);
    }
}
