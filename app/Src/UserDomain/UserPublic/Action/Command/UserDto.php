<?php

namespace App\Src\UserDomain\UserPublic\Action\Command;

use App\Src\Localization\TimeZone\Model\TimeZone;

class UserDto
{
    private string $firstName;

    private string $lastName;

    private string $email;

    private string $school;

    private TimeZone $timeZone;

    public function __construct(string $firstName, string $lastName, string $email, string $school, TimeZone $timeZone)
    {

        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->school = $school;
        $this->timeZone = $timeZone;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSchool(): string
    {
        return $this->school;
    }

    public function getTimeZone(): TimeZone
    {
        return $this->timeZone;
    }
}
