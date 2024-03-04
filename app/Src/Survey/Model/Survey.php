<?php

namespace App\Src\Survey\Model;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Shared\Model\HashIdable;
use App\Src\UniversityDomain\University\Model\University;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Survey extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    protected $table = 'survey';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function surveyable(): MorphTo
    {
        return $this->morphTo();
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function isCourse(): bool
    {
        return $this->surveyable instanceof Course;
    }

    public function isUniversity(): bool
    {
        return $this->surveyable instanceof University;
    }

    public function hasObservations(): bool
    {
        return ! empty($this->observations);
    }

    public function writeType(): string
    {

        if ($this->isUniversity()) {
            return 'University';
        }

        return 'Course';
    }
}
