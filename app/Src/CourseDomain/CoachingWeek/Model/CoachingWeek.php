<?php

namespace App\Src\CourseDomain\CoachingWeek\Model;

use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrderPeriod;
use App\Src\Shared\Model\HashIdable;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class CoachingWeek extends Model implements Auditable, SessionOrderPeriod
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    protected $table = 'coaching_week';

    protected $dates = ['start_date', 'end_date', 'created_at', 'updated_at', 'deleted_at'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function assignment()
    {
        return $this->hasMany(Assignment::class, 'week_id');
    }

    public function isMakeup(): bool
    {
        return $this->is_makeup;
    }

    public function sessionOrder(): int
    {
        return $this->session_order;
    }

    public function sessionOrderObject(): SessionOrder
    {
        $order = $this->session_order;
        if ($order == 0){
            $order = 999;
        }
        return new SessionOrder($order);
    }

    public function period(): CarbonPeriod
    {
        return new CarbonPeriod($this->start_date->startOfDay(), $this->end_date->endOfDay());
    }

    public function isFuture ():bool{
        return $this->start_date->startOfDay()->isFuture();
    }

    public function isPast ():bool{
        return $this->end_date->endOfDay()->isPast();
    }

    public function containsToday():bool{
        return $this->period()->contains($today);
    }

    public function containsDate (Carbon $date):bool{
        return $this->period()->contains($date);
    }

    public function writePeriod(): string
    {
        return $this->start_date->format('m/d/Y').' - '.$this->end_date->format('m/d/Y');
    }

    public function isSame(self $other): bool
    {
        return $this->id === $other->id;
    }

    public function isFullFilled(): bool
    {

        if (is_null($this->attributes['start_date'])) {
            return false;
        }

        if (is_null($this->attributes['end_date'])) {
            return false;
        }

        return true;
    }

    public function hasAssignments(): bool
    {

        $assignments = $this->assignment;

        if (! $assignments->count()) {
            return false;
        }

        foreach ($assignments as $assignment) {

            $assignmentWeek = $assignment->week;

            if ($assignmentWeek) {
                if ($assignmentWeek->isSame($this)) {
                    return $assignment->hasCustomContent();
                }
            }
        }

        return false;
    }

    public function hasPeriod(): bool
    {
        return true;
    }

    public function writeSessionNumber(): string
    {
        if ($this->session_order == 0){
            return 'Makeup';
        }

        return 'Session '.$this->session_order;
    }
}
