<?php

namespace App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model;

use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Model\CoachReview;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\Session\Service\Schedulable;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\CourseDomain\SessionDomain\SessionStatus\Model\SessionStatus;
use App\Src\CourseDomain\SessionDomain\StudentReview\Model\StudentReview;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\Shared\Model\HashIdable;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\ExtraSession\Model\ExtraSession;
use App\Src\StudentDomain\Makeup\Model\Makeup;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class EnrollmentSession extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, Schedulable, HashIdable;

    protected $table = 'enrollment_session';

    //status_at: guarda el momento en el que unc coach cambia el estado de la asistencia a una sesión por parte del estudiante.
    protected $dates = ['day', 'status_at', 'created_at', 'updated_at', 'deleted_at'];

    public function coachReview()
    {
        return $this->hasOne(CoachReview::class);
    }

    public function coachingWeek()
    {
        return $this->belongsTo(CoachingWeek::class);
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function extraSession()
    {
        return $this->belongsTo(ExtraSession::class);
    }

    public function feedback()
    {
        //feedback de los coachs sobre los estudiantes
        return $this->hasOne(StudentReview::class, 'enrollment_session_id', 'id');
    }

    public function makeup()
    {
        return $this->belongsTo(Makeup::class);
    }

    public function recovered()
    {
        return $this->belongsTo(EnrollmentSession::class, 'session_id_recovered')->withTrashed();
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function status()
    {
        return $this->belongsTo(SessionStatus::class, 'session_status_id');
    }

    public function isCoachingWeek(CoachingWeek $coachingWeek): bool
    {
        return $this->coaching_week_id == $coachingWeek->id;
    }

    public function sessionOrder(): SessionOrder
    {
        return new SessionOrder($this->session_order);
    }

    public function isReserved(): bool
    {
        return (! is_null($this->start_time)) and (! is_null($this->end_time));
    }

    public function isDone(): bool
    {
        return $this->session_start->isPast();
    }

    public function isSame(EnrollmentSession $other):bool{
        return $this->id == $other->id;
    }

    public function hasFeedback(): bool
    {
        return ! is_null($this->feedback);
    }

    public function hasCoachingWeek ():bool{
        return !is_null($this->coachingWeek);
    }

    public function isMakeupWeek(): bool
    {

        if ($this->coachingWeek) {
            return $this->coachingWeek->isMakeup();
        }

        return false;
    }

    public function isMakeup ():bool{
        return !is_null($this->makeup_id);
    }

    public function isExtraSession():bool{
        return !is_null($this->extra_session_id);
    }

    public function canChangeStatus (int $hoursLimit):bool{

        $now = Carbon::now();

        $scheduleSesssion = $this->scheduleSession();

        $start = $scheduleSesssion->start()->subHours($hoursLimit);

        return $now->lessThan($start);
    }

    public function isRecoveryFrom(EnrollmentSession $enrollmentSession):bool{
        return $this->session_id_recovered == $enrollmentSession->id;
    }

    public function isRecovery():bool{
        return !is_null($this->session_id_recovered) OR !is_null($this->makeup_id);
    }
}
