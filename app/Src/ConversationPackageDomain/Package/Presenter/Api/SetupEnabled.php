<?php

namespace App\Src\ConversationPackageDomain\Package\Presenter\Api;

use Illuminate\Support\Collection;

class SetupEnabled
{
    private int $durationOfSession;

    private Collection $numberOfSessions;

    public function __construct(int $duration)
    {
        $this->durationOfSession = $duration;

        $this->numberOfSessions = collect();
    }

    public function durationOfSession(): int
    {
        return $this->durationOfSession;
    }

    public function numberOfSessions(): Collection
    {
        return $this->numberOfSessions;
    }

    public function isDurationOfSession(int $otherDuration): bool
    {
        return $this->durationOfSession == $otherDuration;
    }

    public function putNumberOfSessions(int $numberSessions)
    {
        $this->numberOfSessions->put($numberSessions, $numberSessions);
    }

    public function hasNumberOFSessions(int $numberSessions): bool
    {
        return $this->numberOfSessions->has($numberSessions);
    }

    public function toArray(): array
    {
        return [
            $this->durationOfSession => $this->numberOfSessions->toArray(),
        ];
    }
}
