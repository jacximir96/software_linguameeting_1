<?php
namespace App\Src\UniversityDomain\University\Action;


use App\Src\_Old\Model\UniversityLevels;
use App\Src\UniversityDomain\University\Model\University;
use App\Src\UniversityDomain\University\Request\PublicRegisterRequest;

class CreateUniversityFromPublicAction
{

    public function handle(PublicRegisterRequest $request):University{

        $university = new University();
        $university->name = $request->university_name;
        $university->country_id = $request->country_university_id;
        $university->university_level_id = UniversityLevels::NON_DEMANDING_UNIVERSITIES;
        $university->timezone_id = $request->university_timezone_id;
        $university->internal_comment = '';

        $university->save();

        return $university;

    }
}
