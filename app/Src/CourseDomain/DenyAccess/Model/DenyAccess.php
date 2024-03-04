<?php

namespace App\Src\CourseDomain\DenyAccess\Model;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DenyAccess extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'deny_access_course';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isSameCourse(Course $course): bool
    {
        return $this->course_id == $course->id;
    }
}
