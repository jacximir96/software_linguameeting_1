<?php

namespace App\Src\StudentDomain\Enrollment\Presenter;

use App\Src\StudentDomain\ExtraSession\Model\ExtraSession as ExtraSessionModel;
use App\Src\StudentDomain\Makeup\Model\Makeup;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;

class ExtraSession
{
    private Makeup|ExtraSessionModel $extra;

    public function __construct(Makeup|ExtraSessionModel $extra)
    {

        $this->extra = $extra;
    }

    public function get(): Makeup|ExtraSessionModel
    {
        return $this->extra;
    }

    public function writeType(): string
    {
        return $this->isMakeup() ? 'Makeup' : 'Extra Session';
    }

    public function writeOrigin(): string
    {
        return $this->extra->type->name;
    }

    public function allocator(): User
    {
        return $this->extra->allocator;
    }

    public function moment(): Carbon
    {
        return $this->extra->created_at;
    }

    public function isMakeup(): bool
    {
        return $this->extra instanceof Makeup;
    }

    public function hasBeenUsed(): bool
    {
        return false;
    }
}
