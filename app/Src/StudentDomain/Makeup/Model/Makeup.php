<?php

namespace App\Src\StudentDomain\Makeup\Model;

use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\PaymentDomain\PaymentDetail\Model\PaymentDetail;
use App\Src\Shared\Model\Morpheable;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\MakeupType\Model\MakeupType;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Makeup extends Model implements Auditable, Morpheable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    const MORPH = 'makeup';

    protected $table = 'makeup';

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
        return $this->hasOne(EnrollmentSession::class, 'makeup_id');
    }

    public function paymentDetail()
    {
        return $this->morphOne(PaymentDetail::class, 'payable');
    }

    public function type()
    {
        return $this->belongsTo(MakeupType::class, 'makeup_type_id');
    }

    public function isFree(): bool
    {
        return (bool) $this->is_free;
    }

    public function hasBeenUsed(): bool
    {
        return ! is_null($this->enrollmentSession);
    }

    public function morphType(): string
    {
        return self::MORPH;
    }
}
