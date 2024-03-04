<?php

namespace App\Src\Shared\Service;

use App\Src\UserDomain\Role\Service\RoleChecker;
use Spatie\Permission\Models\Role;

class ColorFactory
{
    private RoleChecker $checkerRole;

    public function __construct(RoleChecker $checkerRole)
    {

        $this->checkerRole = $checkerRole;
    }

    public function generateColorRGBA()
    {
        $r = mt_rand(128, 255);
        $g = mt_rand(128, 255);
        $b = mt_rand(128, 255);
        $a = '0.5';
        $rgba = 'rgba('.$r.','.$g.','.$b.','.$a.')';

        return $rgba;
    }

    public function classColorByInstructorRol(Role $role): string
    {

        if ($this->checkerRole->isCoordinator($role)) {
            return 'colorCoordinator';
        } elseif ($this->checkerRole->isCourseCoordinator($role)) {
            return 'colorCourseCoordinator';
        } elseif ($this->checkerRole->isTeachingAssistant($role)) {
            return 'colorTeachingAssistant';
        } elseif ($this->checkerRole->isCourseManager($role)) {
            return 'colorCourseManager';
        }

        return '';
    }
}
