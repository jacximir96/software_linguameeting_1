<?php

namespace App\Src\ConversationPackageDomain\Package\Presenter\Api;

use App\Src\ConversationPackageDomain\SessionType\Model\SessionType;
use App\Src\CourseDomain\Course\Model\SessionSetup;
use App\Src\Shared\Model\ValueObject\JsonObject;
use Illuminate\Support\Collection;

class AvailabilitySetupResponse
{
    private Collection $setupsSessionType;

    public function __construct(Collection $setupsSessionType)
    {
        $this->setupsSessionType = $setupsSessionType;
    }

    public function writeSetupThatUserCanSelect(): JsonObject
    {
        $data = [];

        foreach ($this->setupsSessionType as $setupSessionType) {
            $data[$setupSessionType->sessionType()->id] = $setupSessionType->toArray();
        }

        return JsonObject::createFromArray($data);
    }

    public function isSessionSetupAvailability(SessionType $sessionTypeSelected, SessionSetup $sessionSetup): bool
    {
        foreach ($this->setupsSessionType as $setupSessionType) {
            if ($setupSessionType->sessionType()->isSame($sessionTypeSelected)) {
                if ($setupSessionType->isAvailabilitySessionSetup($sessionSetup)) {
                    return true;
                }
            }
        }

        return false;
    }
}
