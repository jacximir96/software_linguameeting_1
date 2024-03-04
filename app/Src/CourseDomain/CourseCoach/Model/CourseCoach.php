<?php

namespace App\Src\CourseDomain\CourseCoach\Model;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class CourseCoach extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'course_coach';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function section()
    {
        return $this->hasManyThrough(Section::class, Course::class);
    }
}
