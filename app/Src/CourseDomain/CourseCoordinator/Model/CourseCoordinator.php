<?php

namespace App\Src\CourseDomain\CourseCoordinator\Model;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

class CourseCoordinator extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, SoftDeletes, Auditable;

    protected $table = 'course_coordinator';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function course()
    {
        return $this->belongsTo(Course::class)->withTrashed();
    }

    public function person()
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    public function coordinator()
    {
        return $this->person();
    }

    public function accessBlocked(): bool
    {
        return (bool) $this->see_course == false;
    }

    public function isSameCoordinator(User $user): bool
    {
        return $this->coordinator_id == $user->id;
    }

    public function isOtherCoordinator(User $user): bool
    {
        return $this->coordinator_id != $user->id;
    }
}
