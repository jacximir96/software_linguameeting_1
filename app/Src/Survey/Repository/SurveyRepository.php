<?php

namespace App\Src\Survey\Repository;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Survey\Model\Survey;
use App\Src\UniversityDomain\University\Model\University;

class SurveyRepository
{
    public function obtainToIndex()
    {
        return Survey::with('surveyable')->orderBy('created_at', 'desc')->paginate(config('linguameeting.items_per_page'));
    }

    public function activeFromCourse (Course $course):?Survey{

        return Survey::query()
            ->where('surveyable_type', Course::MORPH)
            ->where('surveyable_id', $course->id)
            ->where('active',1)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function activeFromUniversity (University $university):?Survey{

        return Survey::query()
            ->where('surveyable_type', University::MORPH)
            ->where('surveyable_id', $university->id)
            ->where('active',1)
            ->orderBy('id', 'desc')
            ->first();
    }
}
