<?php

namespace App\Src\ConversationPackageDomain\Package\Presenter\Api;

use App\Src\ConversationPackageDomain\SessionType\Model\SessionType;
use App\Src\CourseDomain\Course\Model\SessionSetup;
use Illuminate\Support\Collection;

class AvailabilitySetupSessionType
{
    private SessionType $sessionType;

    /**
     * Key => is session duration: 15, 30, 45..
     * Values => number of sessions: 1,2,3,4...12
     */
    private Collection $setupsEnabled;

    public function __construct(SessionType $sessionType)
    {
        $this->setupsEnabled = collect();

        $this->sessionType = $sessionType;
    }

    public function sessionType(): SessionType
    {
        return $this->sessionType;
    }

    public function putDurationSessionEnabled(int $durationSessions, int $numberSessions)
    {
        if (! $this->setupsEnabled->has($durationSessions)) {
            $setupEnabled = new SetupEnabled($durationSessions);

            $this->setupsEnabled->put($durationSessions, $setupEnabled);
        }

        $setupEnabled = $this->setupsEnabled->get($durationSessions);

        $setupEnabled->putNumberOfSessions($numberSessions);
    }

    public function isAvailabilitySessionSetup(SessionSetup $sessionSetup): bool
    {
        foreach ($this->setupsEnabled as $setupEnabled) {
            if ($setupEnabled->isDurationOfSession($sessionSetup->sessionDuration()->get())) {
                if ($setupEnabled->hasNumberOFSessions($sessionSetup->sessionNumber()->get())) {
                    return true;
                }
            }
        }

        return false;
    }

    public function toArray(): array
    {
        $data = [];

        foreach ($this->setupsEnabled as $setupEnabled) {
            $data[$setupEnabled->durationOfSession()] = $setupEnabled->numberOfSessions()->toArray();
        }

        return $data;
    }
}
