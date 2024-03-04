<?php

namespace App\Src\StudentDomain\ExtraSession\Action;

use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\ExtraSession\Model\ExtraSession;
use App\Src\StudentDomain\ExtraSessionType\Model\ExtraSessionType;
use App\Src\UserDomain\User\Model\User;

class CreateExtraSessionAction
{
    public function handle(Enrollment $enrollment, User $allocator, ExtraSessionType $extraSessionType): ExtraSession
    {

        $extra = new ExtraSession();
        $extra->extra_session_type_id = $extraSessionType->id;
        $extra->allocator_id = $allocator->id;
        $extra->enrollment_id = $enrollment->id;
        $extra->save();

        return $extra;
    }
}
