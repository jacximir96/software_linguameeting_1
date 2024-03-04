<?php

namespace App\Src\CourseDomain\SessionDomain\Session\Request;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\SessionDomain\Session\Presenter\Instructor\InstructorStudentsFilter;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class FilterStudentsByCourseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'instructor_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'instructor_id.required' => trans('common_form.required', ['field' => 'instructor']),
        ];
    }


    public function studentsFilter ():InstructorStudentsFilter{

        $instructor = User::find($this->instructor_id);

        $filter = new InstructorStudentsFilter($instructor);

        $coursesIds = $this->ids('course');

        foreach ($coursesIds as $courseId){
            $course = Course::find($courseId);
            $filter->addCourse($course);
        }


        $sectionsIds = $this->ids('section');

        foreach ($sectionsIds as $sectionId){
            $section = Section::find($sectionId);
            $filter->addSection($section);
        }

        if ($this->hasPeriodFilled()){
            $filter->setPeriod($this->period());
        }

        return $filter;
    }



    private function hasPeriodFilled ():bool{
        return ($this->filled('date_from') AND $this->filled('date_to'));
    }

    private function period ():CarbonPeriod{

        $start = Carbon::parse($this->date_from);
        $end = Carbon::parse($this->date_to);

        return CarbonPeriod::create($start, $end);

    }

    /*
     * data-selected es un array de 'section-1234' o 'course-1234'
     */
    private function filterBy (string $slug):bool{

        if ($this->has('course_selected')){

            foreach ($this->get('course_selected') as $value){

                if (str_contains($value, $slug)){
                    return true;
                }
            }
        }

        return false;
    }

    private function ids (string $slug):Collection{

        $ids = collect();

        if ($this->has('course_selected')){

            foreach ($this->get('course_selected') as $value){

                if (str_contains($value, $slug)){

                    $valueExplode = explode('-', $value);

                    $ids->push($valueExplode[1]);
                }
            }
        }

        return $ids;
    }
}
