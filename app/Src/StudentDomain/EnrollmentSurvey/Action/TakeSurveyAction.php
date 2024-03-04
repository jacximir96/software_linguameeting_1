<?php
namespace App\Src\StudentDomain\EnrollmentSurvey\Action;

use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\EnrollmentSurvey\Model\EnrollmentSurvey;
use App\Src\Survey\Model\Survey;
use Carbon\Carbon;


class TakeSurveyAction
{
    public function handle(Enrollment $enrollment, Survey $survey):EnrollmentSurvey{

        $item = new EnrollmentSurvey();
        $item->enrollment_id = $enrollment->id;
        $item->survey_id = $survey->id;

        $item->surveyed_at = Carbon::now();

        $item->save();

        return $item;
    }
}
