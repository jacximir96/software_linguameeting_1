<?php

namespace App\Src\StudentDomain\Makeup\Action;

use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Makeup\Action\Command\CreateMakeupCommand;
use App\Src\StudentDomain\Makeup\Action\Command\MakeupDto;
use App\Src\StudentDomain\Makeup\Request\AssignMakeupByInstructorFormRequest;
use App\Src\StudentDomain\MakeupType\Model\MakeupType;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;


class AssignMakeupByInstructorAction
{
    private CreateMakeupCommand $createMakeupCommand;

    public function __construct(CreateMakeupCommand $createMakeupCommand)
    {
        $this->createMakeupCommand = $createMakeupCommand;
    }

    public function handle(AssignMakeupByInstructorFormRequest $request, Enrollment $enrollment, User $allocator, MakeupType $makeupType): Collection
    {
        $makeups = collect();

        for ($i= 1; $i<= $request->num_makeups; $i++){
            $dto = new MakeupDto($enrollment, $allocator, $makeupType, false);

            $makeup = $this->createMakeupCommand->handle($dto);

            $makeups->push($makeup);
        }

        return $makeups;
    }
}
