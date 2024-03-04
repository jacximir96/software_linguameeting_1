<?php

namespace App\Src\UserDomain\UserPublic\Model\Traits;

trait Printable
{
    public function writeFullName(): string
    {
        return $this->lastname.', '.$this->name;
    }

    public function writeFullNameAndLastName(): string
    {
        return $this->name.' '.$this->lastname;
    }

    public function getFullNameAttribute(): string
    {
        return $this->writeFullName();
    }
}
