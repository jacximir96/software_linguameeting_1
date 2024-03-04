<?php
namespace App\Src\UserDomain\User\Model\Traits;

use App\Src\ExperienceDomain\ExperienceRegister\Model\ExperienceRegister;


trait Experience
{

    public function experienceRegister (){
        return $this->hasMany(ExperienceRegister::class);
    }

}
