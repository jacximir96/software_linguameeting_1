<?php

namespace App\Src\UniversityDomain\University\Action;

use App\Src\UniversityDomain\University\Model\University;
use App\Src\UniversityDomain\University\Request\UniversityRequest;
use App\Src\UserDomain\User\Model\User;

class CreateUniversityAction
{
    private ProcessRequest $processRequest;

    public function __construct(ProcessRequest $processRequest)
    {
        $this->processRequest = $processRequest;
    }

    public function handle(UniversityRequest $request, User $user): University
    {
        $university = new University();

        $this->processRequest->handle($request, $university, $user);

        $university->save();

        return $university;
    }
}
