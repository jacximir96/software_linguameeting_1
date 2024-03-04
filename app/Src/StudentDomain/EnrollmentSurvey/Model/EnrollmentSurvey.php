<?php
namespace App\Src\StudentDomain\EnrollmentSurvey\Model;

use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\Survey\Model\Survey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class EnrollmentSurvey extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    const MORPH = 'enrollment_survey';

    protected $table = 'enrollment_survey';

    protected $dates = ['surveyed_at', 'created_at', 'updated_at', 'deleted_at'];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'makeup_id');
    }
}
