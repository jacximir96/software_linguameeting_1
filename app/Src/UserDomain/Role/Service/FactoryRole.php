<?php

namespace App\Src\UserDomain\Role\Service;

use Spatie\Permission\Models\Role;

class FactoryRole
{

    public static function getById(int $id):Role{
        return Role::find($id);
    }

    public static function obtainInstructor():Role{

        $id = config('linguameeting.user.roles.ids.teacher');

        return Role::find($id);
    }

    public function obtainCurseCoordinator(): Role
    {

        $id = config('linguameeting.user.roles.ids.course_coordinator');

        return Role::find($id);
    }

    public function obtainCoordinator(): Role
    {

        $id = config('linguameeting.user.roles.ids.coordinator');

        return Role::find($id);
    }

    public function obtainStudent(): Role
    {

        $id = config('linguameeting.user.roles.ids.student');

        return Role::find($id);
    }
}
