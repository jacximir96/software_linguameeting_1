<?php

namespace App\Http\Controllers\Admin\Instructor;

use App\Src\InstructorDomain\Instructor\Presenter\CoordinatorPresenter;
use App\Src\InstructorDomain\Instructor\Presenter\CourseCoordinatorPresenter;
use App\Src\InstructorDomain\Instructor\Presenter\CourseManagerPresenter;
use App\Src\InstructorDomain\Instructor\Presenter\InstructorPresenter;
use App\Src\InstructorDomain\Instructor\Presenter\TeacherAssistantPresenter;
use App\Src\UserDomain\Role\Service\RoleChecker;
use Spatie\Permission\Models\Role;

trait Presentable
{
    public function obtainPresenter(RoleChecker $checkerRole, Role $role)
    {

        if ($checkerRole->isCoordinator($role)) {
            return app(CoordinatorPresenter::class);
        }
        if ($checkerRole->isCourseCoordinator($role)) {
            return app(CourseCoordinatorPresenter::class);
        } elseif ($checkerRole->isCourseManager($role)) {
            return app(CourseManagerPresenter::class);
        } elseif ($checkerRole->isTeachingAssistant($role)) {
            return app(TeacherAssistantPresenter::class);
        }

        return app(InstructorPresenter::class);
    }
}
