<?php
namespace App\Http\Controllers\Admin\Survey;

use App\Http\Controllers\Controller;
use App\Src\Survey\Model\Survey;
use App\Src\Survey\Repository\SurveyRepository;


class IndexSurveyController extends Controller
{

    private SurveyRepository $surveyRepository;

    public function __construct (SurveyRepository $surveyRepository){

        $this->surveyRepository = $surveyRepository;
    }

    public function __invoke()
    {

        $surveys = $this->surveyRepository->obtainToIndex();

        view()->share([
            'surveys' => $surveys
        ]);

        return view('admin.survey.index');
    }
}
