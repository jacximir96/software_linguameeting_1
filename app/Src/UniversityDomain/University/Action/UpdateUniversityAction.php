<?php

namespace App\Src\UniversityDomain\University\Action;

use App\Src\UniversityDomain\University\Model\University;
use App\Src\UniversityDomain\University\Request\UniversityRequest;
use App\Src\UserDomain\User\Model\User;

class UpdateUniversityAction
{
    private ProcessRequest $processRequest;

    public function __construct(ProcessRequest $processRequest)
    {
        $this->processRequest = $processRequest;
    }

    public function handle(UniversityRequest $request, University $university, User $user): University
    {
        $university = $this->processRequest->handle($request, $university, $user);

        $university->save();

        return $university;
    }
}
