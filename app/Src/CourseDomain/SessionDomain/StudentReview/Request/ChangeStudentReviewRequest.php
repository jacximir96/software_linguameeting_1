<?php

namespace App\Src\CourseDomain\SessionDomain\StudentReview\Request;

use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\ParticipationType;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\PreparedClassType;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\PunctualityType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class ChangeStudentReviewRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'student_review_id' => 'required',
            'student_review_type' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'student_review_id.required' => trans('common_form.required', ['field' => 'student review id']),
            'student_review_type.required' => trans('common_form.required', ['field' => 'feedback type']),
        ];
    }

    public function id(): int
    {
        return $this->student_review_id;
    }

    public function sessionFeedbackTypeSelected(): Model
    {

        if ($this->student_review_type == 'puntuality') {
            return new PunctualityType();
        } elseif ($this->student_review_type == 'prepared-class') {
            return new PreparedClassType();
        } elseif ($this->student_review_type == 'participation') {
            return new ParticipationType();
        }

        throw new \Exception('Session feedback type not found');
    }
}
