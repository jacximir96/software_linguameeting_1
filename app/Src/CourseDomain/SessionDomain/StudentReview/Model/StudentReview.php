<?php

namespace App\Src\CourseDomain\SessionDomain\StudentReview\Model;

use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\CourseDomain\SessionDomain\StudentReview\Service\Grade;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\ParticipationType;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\PreparedClassType;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\PunctualityType;
use App\Src\Shared\Model\HashIdable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

//guarda la valoración de los coach a los estudiantes
class StudentReview extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    protected $table = 'student_review';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function enrollmentSession()
    {
        return $this->belongsTo(EnrollmentSession::class);
    }

    public function participationType()
    {
        //dd($this->id);
        return $this->belongsTo(ParticipationType::class);
    }

    public function preparedClassType()
    {
        return $this->belongsTo(PreparedClassType::class);
    }

    public function puntualityType()
    {
        return $this->belongsTo(PunctualityType::class);
    }

    public function hasObservations(): bool
    {
        return ! empty($this->observations);
    }

    public function hasGrade ():bool{

        if (is_null($this->participation_type_id)){
            return false;
        }

        if (is_null($this->prepared_class_type_id)){
            return false;
        }

        if (is_null($this->puntuality_type_id)){
            return false;
        }

        return true;

    }

    public function grade ():Grade{

        if ( ! $this->hasGrade()){
            $zero = new Grade(0);

            return new Grade($zero, $zero, $zero);
        }

        return new Grade($this->participationType->grade(), $this->preparedClassType->grade(), $this->puntualityType->grade());
    }

    public function sessionOrder ():SessionOrder{

        return $this->enrollmentSession->sessionOrder();

    }
}
