<?php

namespace App\Src\UniversityDomain\University\Action;

use App\Src\UniversityDomain\University\Model\University;
use App\Src\UniversityDomain\University\Request\UniversityRequest;
use App\Src\UserDomain\User\Model\User;

class ProcessRequest
{
    public function handle(UniversityRequest $request, University $university, User $user): University
    {
        $university->name = $request->name;
        $university->country_id = $request->country_id;
        $university->university_level_id = $request->university_level_id;
        $university->timezone_id = $request->timezone_id;
        $university->internal_comment = $request->internal_comment ?? '';

        return $university;
    }
}
