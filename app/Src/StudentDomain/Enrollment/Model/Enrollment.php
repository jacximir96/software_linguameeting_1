<?php

namespace App\Src\StudentDomain\Enrollment\Model;

use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\PaymentDomain\PaymentDetail\Model\PaymentDetail;
use App\Src\Shared\Model\HashIdable;
use App\Src\Shared\Model\Morpheable;
use App\Src\StudentDomain\Accommodation\Model\Accommodation;
use App\Src\StudentDomain\EnrollmentStatus\Model\EnrollmentStatus;
use App\Src\StudentDomain\ExtraSession\Model\ExtraSession;
use App\Src\StudentDomain\Makeup\Model\Makeup;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Enrollment extends Model implements Auditable, Morpheable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    const MORPH = 'enrollment';

    protected $table = 'enrollment';

    protected $dates = ['status_at', 'created_at', 'updated_at', 'deleted_at'];

    public function course()
    {
        return $this->section->course;
    }

    public function accommodation()
    {
        return $this->hasOne(Accommodation::class);
    }

    public function enrollmentSession()
    {
        return $this->hasMany(EnrollmentSession::class);
    }

    public function extraSession()
    {
        return $this->hasMany(ExtraSession::class);
    }

    public function makeup()
    {
        return $this->hasMany(Makeup::class);
    }

    public function enrollmentOrigin (){
        //soy la destino y esta relación me retorna de donde vine con un cambio
        return $this->belongsTo(Enrollment::class, 'origin_enrollment_id', 'id')->withTrashed();
    }

    public function enrollmentTarget (){
        //soy la origen y esta relación me retorna hacia la que me he cambiado
        return $this->hasOne(Enrollment::class, 'origin_enrollment_id', 'id')->withTrashed();
    }

    //check
    public function paymentDetail()
    {
        return $this->morphOne(PaymentDetail::class, 'payable');
    }

    public function section()
    {
        return $this->belongsTo(Section::class)->withTrashed();
    }

    public function status (){
        return $this->belongsTo(EnrollmentStatus::class)->withTrashed();
    }

    public function university()
    {
        return $this->course()->university;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function isActive(): bool
    {
        return $this->status_id == EnrollmentStatus::ACTIVE_ID;
    }

    public function hasIntroSession():bool{
        return (bool)$this->intro_session;
    }

    public function hasEnrollmentOrigin ():bool{
        return !is_null($this->origin_enrollment_id);
    }

    public function morphType(): string
    {
        return self::MORPH;
    }

    public function sessionsSortedBySessionNumber(){
        return $this->enrollmentSession->sortBy(function ($enrollmentSession){
            return $enrollmentSession->sessionOrder()->get();
        });
    }


}
