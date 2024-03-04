<?php
namespace App\Http\Controllers\Admin\Survey;

use App\Http\Controllers\Controller;
use App\Src\Survey\Model\Survey;


class ShowSurveyController extends Controller
{
    public function __invoke(Survey $survey)
    {

        view()->share([
            'survey' => $survey
        ]);

        return view('admin.survey.show');
    }
}
