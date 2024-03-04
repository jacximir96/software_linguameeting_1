<?php
namespace App\Src\StudentDomain\EnrollmentStatus\Model;

use App\Src\Shared\Model\HashIdable;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class EnrollmentStatus extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    const MORPH = 'enrollment_status';

    const ACTIVE_ID = 1;
    const ENDED_ID = 2;
    const REFUNDED_ID = 3;
    const CHANGED_ID = 4;

    protected $table = 'enrollment_status';

    protected $dates = [ 'created_at', 'updated_at', 'deleted_at'];


    public function enrollment()
    {
        return $this->hasMany(Enrollment::class, 'status_id');
    }

    public function description ():string{
        return trans('student.enrollment.status.description.'.$this->slug) ?? '-';
    }

    public function isActive ():bool{
        return $this->id == self::ACTIVE_ID;
    }

    public function isChanged():bool{
        return $this->id == self::CHANGED_ID;
    }
}
