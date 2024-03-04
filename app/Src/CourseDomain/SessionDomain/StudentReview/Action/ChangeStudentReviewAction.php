<?php

namespace App\Src\CourseDomain\SessionDomain\StudentReview\Action;

use App\Src\CourseDomain\SessionDomain\StudentReview\Model\StudentReview;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\StudentReviewType;

class ChangeStudentReviewAction
{
    public function handle(StudentReview $sessionFeedback, StudentReviewType $type, int $id): StudentReview
    {

        $column = $type->column();

        $sessionFeedback->$column = $id;
        $sessionFeedback->save();

        return $sessionFeedback;
    }
}
