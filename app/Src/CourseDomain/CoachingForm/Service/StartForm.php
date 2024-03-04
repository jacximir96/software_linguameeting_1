<?php

namespace App\Src\CourseDomain\CoachingForm\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;

class StartForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $universityOptions;

    private array $courseOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function config(User $user)
    {

        $this->initialize();

        if ($user->isInstructor()){
           $this->configForInstructor($user);

        }else{
            $this->configForAdmin($user);
        }
    }

    private function initialize (){
        $this->model = [];
        $this->universityOptions = [];
        $this->courseOptions = [];
    }

    public function configForInstructor (User $instructor){

        $this->action = route('post.admin.course.coaching_form.create.zero_step');
        // Aquí hay que poner sólo lo del instructor
        $this->universityOptions = $this->fieldFormBuilder->obtainUniversityInstructorOptions($instructor);

        if (old('course_id')){
            $this->courseOptions = $this->fieldFormBuilder->obtainCourseOptionsFromUniversities([old('university_id')]);
        }
    }

    private function configForAdmin (User $user){
        $this->universityOptions = $this->fieldFormBuilder->obtainUniversityOptions();
        $this->action = route('post.admin.course.coaching_form.create.zero_step');
    }

}
