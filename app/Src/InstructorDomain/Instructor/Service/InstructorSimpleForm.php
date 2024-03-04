<?php

namespace App\Src\InstructorDomain\Instructor\Service;

use App\Src\Localization\Language\Model\Language;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\UniversityDomain\University\Model\University;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

class InstructorSimpleForm extends BaseSearchForm
{

    private Collection $roleOptions;

    public function __construct (){
        $this->roleOptions = collect();
    }

    public function roleOptions ():Collection{
        return $this->roleOptions;
    }

    public function configToCreate(University $university, Language $language)
    {
        $this->action = route('post.common.course.instructor.simple.create', [$university->hashId(), $language->id]);

        $this->model = [];

        $this->configRoleOptions();
    }

    private function configRoleOptions (){

        $roleIds = [
            config('linguameeting.user.roles.ids.coordinator'),
            config('linguameeting.user.roles.ids.course_manager'),
            config('linguameeting.user.roles.ids.teacher'),
        ];

        $this->roleOptions = Role::whereIn('id', $roleIds)->get();
    }
}
