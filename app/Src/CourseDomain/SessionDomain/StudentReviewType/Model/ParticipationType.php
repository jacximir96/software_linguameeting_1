<?php

namespace App\Src\CourseDomain\SessionDomain\StudentReviewType\Model;

use App\Src\CourseDomain\SessionDomain\StudentReview\Model\StudentReview;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ParticipationType extends Model implements Auditable, StudentReviewType
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, GradeTrait;

    const DESCRIPCION = 'participation';

    protected $table = 'participation_type';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function feedback()
    {
        return $this->hasMany(StudentReview::class);
    }

    public function column(): string
    {
        return 'participation_type_id';
    }
}
