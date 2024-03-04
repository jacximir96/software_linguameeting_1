<?php
namespace App\Src\StudentDomain\EnrollmentSurvey\Action;

use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\EnrollmentSurvey\Model\EnrollmentSurvey;
use Carbon\Carbon;


class TakeDefaultSurveyAction
{
    public function handle(Enrollment $enrollment):EnrollmentSurvey{

        $item = new EnrollmentSurvey();
        $item->enrollment_id = $enrollment->id;
        $item->surveyed_at = Carbon::now();

        $item->save();

        return $item;
    }
}
