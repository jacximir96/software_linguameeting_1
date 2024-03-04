<?php

namespace App\Src\CourseDomain\Holiday\Model;

use App\Src\CourseDomain\Course\Model\Course;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Holiday extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'course_holiday';

    protected $dates = ['date', 'created_at', 'updated_at', 'deleted_at'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function isSameDay (Carbon $date):bool{
        return $this->date->toDateString() == $date->toDateString();
    }
}
