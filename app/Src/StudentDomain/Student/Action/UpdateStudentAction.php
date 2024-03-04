<?php

namespace App\Src\StudentDomain\Student\Action;

use App\Src\StudentDomain\Student\Request\StudentRequest;
use App\Src\UserDomain\User\Model\User;

class UpdateStudentAction
{
    private StudentRequest $request;

    private User $student;

    private ProcessRequest $processRequest;

    public function __construct(ProcessRequest $processRequest)
    {

        $this->processRequest = $processRequest;
    }

    public function handle(StudentRequest $request, User $student): User
    {

        $this->initialize($request, $student);

        $this->updatePersonalData();

        return $this->student;
    }

    private function initialize(StudentRequest $request, User $student)
    {

        $this->request = $request;
        $this->student = $student;
    }

    private function updatePersonalData()
    {
        $this->student = $this->processRequest->updatePersonalData($this->request, $this->student);
    }
}
