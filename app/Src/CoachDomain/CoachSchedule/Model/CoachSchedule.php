<?php

namespace App\Src\CoachDomain\CoachSchedule\Model;

use App\Src\CoachDomain\CoachSchedule\Service\DateSlot;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\Session\Model\SessionTimeable;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\Shared\Model\HashIdable;
use App\Src\Shared\Model\Timezonable;
use App\Src\Shared\Model\ValueObject\Time;
use App\Src\StudentRole\BookSession\Service\Availability\TimeSlot;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoachSchedule extends Model
{
    use HasFactory, SoftDeletes, SessionTimeable, HashIdable;

    protected $table = 'coach_schedule';

    protected $dates = ['day', 'created_at', 'updated_at', 'deleted_at'];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function course(){
        return $this->session->course;
    }

    public function session()
    {
        return $this->hasOne(Session::class, 'id', 'session_id');
    }

    public function hasSession ():bool{
        return !is_null($this->session_id);
    }

    public function isReserved(): bool
    {
        return ! is_null($this->session_id);
    }

    public function canBeDeleted(): bool
    {
        return ! $this->isReserved();
    }

    public function isBlocked(): bool
    {
        return (bool) $this->blocked_ses;
    }

    public function start(): Carbon
    {
        return Carbon::parse($this->day->toDateString().' '.$this->start_time);
    }

    public function end(): Carbon
    {
        return Carbon::parse($this->day->toDateString().' '.$this->end_time);
    }

    public function startWithOtherTimezone(TimeZone $timezone):Carbon
    {
        return Carbon::parse($this->day->toDateString().' '.$this->start_time)->setTimezone($timezone->name);
    }

    public function startAsTime(): Time
    {
        return new Time($this->start_time);
    }

    public function endAsTime(): Time
    {
        return new Time($this->end_time);
    }

    public function startTimeWithoutSeconds(): string
    {
        return date('H:i', strtotime($this->start_time));
    }

    public function endTimeWithoutSeconds(): string
    {
        return date('H:i', strtotime($this->end_time));
    }

    public function toSlot(): DateSlot
    {

        $start = Carbon::parse($this->day->toDateString().' '.$this->start_time);
        $end = Carbon::parse($this->day->toDateString().' '.$this->end_time);

        return new DateSlot($start, $end);
    }

    public function toBookSessionSlot(): TimeSlot
    {

        $start = new Time($this->start_time);
        $end = new Time($this->end_time);

        return new TimeSlot($start, $end);
    }

    public function otherIsSuccesive(CoachSchedule $otherCoachSchedule): bool
    {
        $endTime = $this->endTime()->clone()->addSecond();

        return $endTime->eq($otherCoachSchedule->start());
    }

    public function printSlot(): string
    {
        return $this->id.' '.$this->day->format('Y-m-d').' '.$this->start_time.' '.$this->end_time;
    }
}
