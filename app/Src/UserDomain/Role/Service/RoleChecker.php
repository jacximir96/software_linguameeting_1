<?php

namespace App\Src\UserDomain\Role\Service;

use Spatie\Permission\Models\Role;

class RoleChecker
{
    public function isCoordinator(Role $role)
    {
        return $this->checkRole($role, 'coordinator');
    }

    public function isCourseCoordinator(Role $role)
    {
        return $this->checkRole($role, 'course_coordinator');
    }

    public function isCourseManager(Role $role)
    {
        return $this->checkRole($role, 'course_manager');
    }

    public function isTeacher(Role $role)
    {
        return $this->checkRole($role, 'teacher');
    }

    public function isTeachingAssistant(Role $role)
    {
        return $this->checkRole($role, 'teaching_assistant');
    }

    public function isSomeTeacher(Role $role)
    {
        if ($this->isCoordinator($role)){
            return true;
        }

        if ($this->isCourseManager($role)){
            return true;
        }

        if ($this->isCourseCoordinator($role)){
            return true;
        }

        if ($this->isTeacher($role)){
            return true;
        }

        if($this->isTeachingAssistant($role)){

            return true;
        }

        return false;
    }

    public function isSomeCoach(Role $role)
    {

        if ($this->isCoach($role)) {
            return true;
        }

        if ($this->isCoachCoordinator($role)) {
            return true;
        }

        return false;
    }

    public function isCoach(Role $role)
    {
        if ($this->checkRole($role, 'coach')) {
            return true;
        }

        return false;
    }

    public function isCoachCoordinator(Role $role)
    {
        if ($this->checkRole($role, 'coach_coordinator')) {
            return true;
        }

        return false;
    }

    public function isStudent(Role $role)
    {
        return $this->checkRole($role, 'student');
    }

    private function checkRole(Role $role, string $roleKey): bool
    {

        $roles = config('linguameeting.user.roles.ids');

        return $roles[$roleKey] == $role->id;
    }
}
