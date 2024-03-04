<?php

namespace App\Src\StudentDomain\ExtraSession\Model;

use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\Shared\Model\HashIdable;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\ExtraSessionType\Model\ExtraSessionType;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ExtraSession extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    protected $table = 'extra_session';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function allocator()
    {
        return $this->belongsTo(User::class, 'allocator_id');
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function enrollmentSession()
    {
        return $this->hasOne(EnrollmentSession::class, 'extra_session_id');
    }

    public function type()
    {
        return $this->belongsTo(ExtraSessionType::class, 'extra_session_type_id');
    }

    public function hasBeenUsed(): bool
    {
        return ! is_null($this->enrollmentSession);
    }
}
