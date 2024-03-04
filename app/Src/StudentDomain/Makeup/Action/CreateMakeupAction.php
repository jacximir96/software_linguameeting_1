<?php

namespace App\Src\StudentDomain\Makeup\Action;

use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Makeup\Action\Command\CreateMakeupCommand;
use App\Src\StudentDomain\Makeup\Action\Command\MakeupDto;
use App\Src\StudentDomain\Makeup\Model\Makeup;
use App\Src\StudentDomain\Makeup\Request\MakeupFormRequest;
use App\Src\StudentDomain\MakeupType\Model\MakeupType;
use App\Src\UserDomain\User\Model\User;

class CreateMakeupAction
{
    private CreateMakeupCommand $createMakeupCommand;

    public function __construct(CreateMakeupCommand $createMakeupCommand)
    {

        $this->createMakeupCommand = $createMakeupCommand;
    }

    public function handle(MakeupFormRequest $request, Enrollment $enrollment, User $allocator, MakeupType $makeupType): Makeup
    {

        $dto = new MakeupDto($enrollment, $allocator, $makeupType, $request->is_free);

        $makeup = $this->createMakeupCommand->handle($dto);

        return $makeup;
    }
}
