<?php

namespace App\Src\CourseDomain\SessionDomain\Session\Model;

use App\Src\CoachDomain\CoachSchedule\Model\CoachSchedule;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\ReplacedCoach\Model\ReplacedCoach;
use App\Src\CourseDomain\SessionDomain\Session\Service\HtmlFormatter;
use App\Src\CourseDomain\SessionDomain\Session\Service\Occupation;
use App\Src\CourseDomain\SessionDomain\Session\Service\Schedulable;
use App\Src\CourseDomain\SessionDomain\SessionStatus\Model\SessionStatus;
use App\Src\Shared\Model\HashIdable;
use App\Src\UserDomain\User\Model\User;
use App\Src\ZoomDomain\ZoomRecording\Model\ZoomRecording;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Session extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, Schedulable, Scopable, HashIdable, SessionTimeable;

    protected $table = 'session';

    protected $dates = ['day', 'created_at', 'updated_at', 'deleted_at'];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function coachSchedule()
    {
        return $this->hasMany(CoachSchedule::class)->orderBy('day')->orderBy('start_time');
    }

    public function coachSessionStatus()
    {
        return $this->belongsTo(SessionStatus::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function enrollmentSession()
    {
        return $this->hasMany(EnrollmentSession::class)->orderBy('id');
    }

    public function replacedCoach()
    {
        return $this->hasMany(ReplacedCoach::class);
    }

    public function zoomRecording()
    {
        return $this->hasOne(ZoomRecording::class);
    }

    public function occupation(): Occupation
    {
        return new Occupation($this->enrollmentSession->count(), $this->course->student_class);
    }

    public function coachIsOwner(User $coach): bool
    {
        return $this->coach_id == $coach->id;
    }

    public function htmlFormatter(): HtmlFormatter
    {
        return new HtmlFormatter($this);
    }

    public function isBlocked(): bool
    {
        return (bool) $this->is_blocked;
    }

    public function hasStudent (User $user):bool{

        foreach ($this->enrollmentSession as $enrollmentSession){

            if ($enrollmentSession->enrollment->user->isSame($user)){
                return true;
            }
        }

        return false;
    }

    public function isPossibleJoinSession ():bool{

        $scheduleSession = $this->scheduleSession();

        $now = Carbon::now();

        if ($scheduleSession->period()->contains($now)){
            //si la clase ya ha empezado y no ha finalizado
            return true;
        }

        if ($scheduleSession->isPast()){
            //si la clase ya ha pasado
            return false;
        }

        $startTime = $this->scheduleSession()->start();

        if ($scheduleSession->isFuture() AND $startTime->diffInSeconds($now) <= 120){
            //si clase aún no ha comenzado y quedan menos de dos minutos para comenzar la clase
            return true;
        }

        //en cualquier otro caso
        return false;
    }
}
