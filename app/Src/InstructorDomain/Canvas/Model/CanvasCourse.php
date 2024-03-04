<?php

namespace App\Src\InstructorDomain\Canvas\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Src\CourseDomain\Course\Model\Course;

/**
 * Description of CanvasCourse
 *
 * @author Sandra
 */
class CanvasCourse extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'canvas_course';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function canvas()
    {
        return $this->hasMany(Course::class);
    }
}
