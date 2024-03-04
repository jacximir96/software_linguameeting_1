<?php

namespace App\Src\TimeDomain\TimeHour\Model;

use App\Src\Shared\Model\HashIdable;
use App\Src\StudentRole\BookSession\Service\Availability\TimeSlot;
use App\Src\TimeDomain\Time\Model\Time;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class TimeHour extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    protected $table = 'time_hour';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function time()
    {
        return $this->belongsTo(Time::class);
    }

    public function toBookSessionSlot(): TimeSlot
    {

        $start = new \App\Src\Shared\Model\ValueObject\Time($this->start);
        $end = new \App\Src\Shared\Model\ValueObject\Time($this->end);

        return new TimeSlot($start, $end);
    }

    public function inRange(Carbon $moment): bool
    {

        if ($moment->toTimeString() < $this->start) {
            return false;
        }

        if ($moment->toTimeString() >= $this->end) {
            return false;
        }

        return true;
    }

    public function isSameId(int $otherId): bool
    {
        return $this->id == $otherId;
    }

    public function isLastMinute(Carbon $date):bool{

        $now = Carbon::now();

        $moment = Carbon::parse($date->toDateString().' '.$this->start);

        return $now->floatDiffInRealHours ($moment) < config('linguameeting.course.session.hours_limit.last_minute');

    }

    public function print(): string
    {
        return $this->start.' '.$this->end;
    }
}
