<?php

namespace App\Src\StudentDomain\Makeup\Action\Command;

use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\MakeupType\Model\MakeupType;
use App\Src\UserDomain\User\Model\User;

class MakeupDto
{
    private Enrollment $enrollment;

    private User $allocator;

    private MakeupType $makeupType;

    private bool $isFree;

    public function __construct(Enrollment $enrollment, User $allocator, MakeupType $makeupType, bool $isFree)
    {

        $this->enrollment = $enrollment;
        $this->allocator = $allocator;
        $this->makeupType = $makeupType;
        $this->isFree = $isFree;
    }

    public function enrollment(): Enrollment
    {
        return $this->enrollment;
    }

    public function allocator(): User
    {
        return $this->allocator;
    }

    public function makeupType(): MakeupType
    {
        return $this->makeupType;
    }

    public function isFree(): bool
    {
        return $this->isFree;
    }
}
