<?php
namespace App\Src\ExperienceDomain\Level\Action;

use App\Src\ExperienceDomain\Level\Exception\LevelHasExperience;
use App\Src\ExperienceDomain\Level\Model\Level;


class DeleteExperienceLevelAction
{
    public function handle(Level $level): Level
    {

        if ($level->experience()->count()){
            throw new LevelHasExperience();
        }

        $level->delete();

        return $level;

    }
}
