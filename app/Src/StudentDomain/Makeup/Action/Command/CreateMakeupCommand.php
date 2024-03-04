<?php
namespace App\Src\StudentDomain\Makeup\Action\Command;

use App\Src\StudentDomain\Makeup\Model\Makeup;

class CreateMakeupCommand
{
    public function handle(MakeupDto $dto): Makeup
    {

        $makeup = new Makeup();
        $makeup->enrollment_id = $dto->enrollment()->id;
        $makeup->allocator_id = $dto->allocator()->id;
        $makeup->makeup_type_id = $dto->makeupType()->id;
        $makeup->is_free = $dto->isFree();

        $makeup->save();



        return $makeup;

    }
}
