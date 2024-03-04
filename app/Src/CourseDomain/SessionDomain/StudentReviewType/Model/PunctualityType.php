<?php

namespace App\Src\CourseDomain\SessionDomain\StudentReviewType\Model;

use App\Src\CourseDomain\SessionDomain\StudentReview\Model\StudentReview;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PunctualityType extends Model implements Auditable, StudentReviewType
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, GradeTrait;

    const DESCRIPCION = 'punctuality';

    protected $table = 'puntuality_type';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function feedback()
    {
        return $this->hasMany(StudentReview::class);
    }

    public function column(): string
    {
        return 'puntuality_type_id';
    }
}
