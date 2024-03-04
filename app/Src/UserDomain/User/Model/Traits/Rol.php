<?php

namespace App\Src\UserDomain\User\Model\Traits;

use App\Src\UserDomain\Role\Service\RoleChecker;

trait Rol
{
    public function getRoleName()
    {
        return $this->getRoleNames();
    }

    public function hasAdminRoles(): bool
    {
        return $this->hasRole(['Administrator', 'Manager', 'Super Admin']);
    }

    public function hasStudentRol(): bool
    {
        return $this->hasRole(['Student']);
    }

    //alias
    public function isAdmin(): bool
    {
        return $this->hasAdminRoles();
    }

    public function isCoach()
    {

        $rolChecker = new RoleChecker();

        return $rolChecker->isSomeCoach($this->rol());

    }

    public function isStudent(): bool
    {
        $rolChecker = new RoleChecker();

        return $rolChecker->isStudent($this->rol());
    }

    public function isInstructor (){

        $rolChecker = new RoleChecker();

        return $rolChecker->isSomeTeacher($this->rol());

    }

    public function isExactlyInstructor (){

        $rolChecker = new RoleChecker();

        return $rolChecker->isTeacher($this->rol());

    }

    public function rol()
    {
        return $this->roles()->first();
    }
}
