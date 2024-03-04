<?php
namespace App\Src\InstructorDomain\CoordinatorRequest\Action;

use App\Src\InstructorDomain\CoordinatorRequest\Model\CoordinatorRequest;
use App\Src\UserDomain\User\Model\User;

class CreateCoordinatorRequestAction
{

    public function handle(User $user):CoordinatorRequest{

        $request = new CoordinatorRequest();
        $request->user_id = $user->id;
        $request->save();

        return $request;
    }
}
