<?php

namespace App\Src\CoachDomain\Coach\Service;

use App\Src\UserDomain\Hobby\Model\Hobby;
use App\Src\UserDomain\User\Model\User;

trait CoachableForm
{
    protected function configModelHobbies(User $coach)
    {

        $this->model['hobbies'] = [];
        foreach ($coach->hobby as $hobby) {
            $this->model['hobbies'][$hobby->id] = $hobby->description;
        }

        $this->model['new_hobbies'] = [];
        if ($coach->hobby->count() < Hobby::MAX_HOBBIES_BY_USER) {

            $remainder = Hobby::MAX_HOBBIES_BY_USER - $coach->hobby->count();

            for ($i = 1; $i <= $remainder; $i++) {
                $this->model['new_hobbies'][$i] = '';
            }
        }
    }

    protected function configModelNewHobbies()
    {

        $this->model['hobbies'] = [];

        for ($i = 1; $i <= Hobby::MAX_HOBBIES_BY_USER; $i++) {
            $this->model['new_hobbies'][$i] = '';
        }
    }
}
