<?php

namespace App\Src\ExperienceDomain\Level\Action;


use App\Src\ExperienceDomain\Level\Model\Level;
use App\Src\ExperienceDomain\Level\Request\ExperienceLevelRequest;

class CreateExperienceLevelAction
{
    public function handle(ExperienceLevelRequest $request): Level
    {

        $level = new Level();
        $level->name = $request->name;
        $level->save();

        return $level;
    }
}
