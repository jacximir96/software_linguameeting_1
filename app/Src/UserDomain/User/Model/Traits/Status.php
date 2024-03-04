<?php

namespace App\Src\UserDomain\User\Model\Traits;

use App\Src\UserDomain\Status\Service\StatusFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\RateLimiter;

trait Status
{
    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }

    public function scopeNoDemo(Builder $query): void
    {
        $query->whereNotIn('id', [245, 244, 243, 242, 241, 26]);
    }

    public function isActive(): bool
    {
        return (bool) $this->active;
    }

    public function isDisabled(): bool
    {
        return ! $this->isActive();
    }

    public function isDeleted()
    {
        return !is_null($this->deleted_at);
    }

    public function status(): \App\Src\UserDomain\Status\Model\Status
    {
        $factory = new StatusFactory();

        return $factory->buildFromUser($this);
    }

    public function isLocked(): bool
    {

        if ($this->locked) {

            $seconds = RateLimiter::availableIn($this->throttleKey(), config('linguameeting.login.maxAttempts'));

            if ($seconds == 0) {
                $this->locked = 0;
                $this->save();
            }
        }

        return (bool) $this->locked;
    }

    public function minutesToEndLock(): int
    {

        if ($this->isLocked()) {

            $seconds = RateLimiter::availableIn($this->throttleKey(), config('linguameeting.login.maxAttempts'));

            return round($seconds / 60, 0);
        }

        return 0;
    }
}
