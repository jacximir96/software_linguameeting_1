<?php

namespace App\Src\StudentDomain\Makeup\Action;

use App\Src\StudentDomain\Makeup\Model\Makeup;
use App\Src\StudentDomain\Makeup\Request\MakeupFormRequest;

class UpdateMakeupAction
{
    public function handle(MakeupFormRequest $request, Makeup $makeup): Makeup
    {

        $makeup->is_free = $request->is_free;
        $makeup->save();

        return $makeup;
    }
}
