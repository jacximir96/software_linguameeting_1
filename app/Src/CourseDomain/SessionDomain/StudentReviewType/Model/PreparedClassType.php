<?php

namespace App\Src\CourseDomain\SessionDomain\StudentReviewType\Model;

use App\Src\CourseDomain\SessionDomain\StudentReview\Model\StudentReview;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PreparedClassType extends Model implements Auditable, StudentReviewType
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, GradeTrait;

    const DESCRIPCION = 'prepared';

    protected $table = 'prepared_class_type';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function feedback()
    {
        return $this->hasMany(StudentReview::class);
    }

    public function column(): string
    {
        return 'prepared_class_type_id';
    }
}
