<?php
namespace App\Src\Survey\Service;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Survey\Repository\SurveyRepository;


class SurveyFinder
{

    private SurveyRepository $surveyRepository;

    public function __construct (SurveyRepository $surveyRepository){
        $this->surveyRepository = $surveyRepository;
    }

    public function findFromCourse (Course $course):ViewSurvey{

        $courseSurvey = $this->surveyRepository->activeFromCourse($course);

        if ($courseSurvey){
            return new ActiveViewSurvey($courseSurvey);
        }

        $universitySurvey = $this->surveyRepository->activeFromUniversity($course->university);
        if ($universitySurvey){
            return new ActiveViewSurvey($universitySurvey);
        }

        return new DefaultViewSurvey();
    }
}
