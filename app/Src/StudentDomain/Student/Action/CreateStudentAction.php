<?php

namespace App\Src\StudentDomain\Student\Action;

use App\Src\ActivityLog\Service\Properties\PropertyBuilder;
use App\Src\StudentDomain\Student\Request\StudentRequest;
use App\Src\UserDomain\Password\Service\PasswordService;
use App\Src\UserDomain\Role\Service\FactoryRole;
use App\Src\UserDomain\User\Model\User;
use Spatie\Activitylog\Models\Activity;

class CreateStudentAction
{
    private StudentRequest $request;

    private User $student;

    private ProcessRequest $processRequest;

    private FactoryRole $factoryRole;

    private PasswordService $passwordService;

    public function __construct(ProcessRequest $processRequest, FactoryRole $factoryRole, PasswordService $passwordService)
    {

        $this->processRequest = $processRequest;
        $this->factoryRole = $factoryRole;
        $this->passwordService = $passwordService;
    }

    public function handle(StudentRequest $request, User $creator): User
    {

        $this->initialize($request);

        $this->createStudent($creator);

        $this->updatePersonalData();

        $this->assignRole();

        $this->registerActivity();

        $this->student->sendEmailVerificationNotificationWithPassword($this->plainPassword);

        return $this->student;
    }

    private function initialize(StudentRequest $request)
    {
        $this->request = $request;
    }

    private function createStudent(User $creator)
    {

        $this->student = new User();
    }

    private function updatePersonalData()
    {

        $this->plainPassword = $this->request->password ?? $this->passwordService->generatePassword();
        $this->student->password = $this->plainPassword;

        $this->student = $this->processRequest->updatePersonalData($this->request, $this->student);
    }

    private function assignRole()
    {
        $this->student->assignRole($this->factoryRole->obtainStudent()->id);
    }

    private function registerActivity ():Activity{

        $properties =  array_merge(
            PropertyBuilder::buildIp(request()->ip())->buildProperty('ip'),
        );


        return activity()
            ->causedBy(user())
            ->performedOn($this->student)
            ->withProperties($properties)
            ->log(config('linguameeting_log.activity.keys.student.create'));
    }
}
