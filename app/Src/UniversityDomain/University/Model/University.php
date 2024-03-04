<?php

namespace App\Src\UniversityDomain\University\Model;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Service\Status\StatusLingro;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\Localization\Country\Model\Country;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\RegisterCodeDomain\BookstoreRequest\Model\BookstoreRequest;
use App\Src\RegisterCodeDomain\BookstoreRequest\Service\StatusCourses;
use App\Src\Shared\Model\HashIdable;
use App\Src\Survey\Model\Survey;
use App\Src\UniversityDomain\Level\Model\Level;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class University extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    const MORPH = 'university';

    protected $table = 'university';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function course()
    {
        return $this->hasMany(Course::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'university_level_id');
    }

    public function bookstoreRequest()
    {
        return $this->hasMany(BookstoreRequest::class);
    }

    public function experience (){
        return $this->hasMany(Experience::class);
    }

    public function survey(): MorphMany
    {
        return $this->morphMany(Survey::class, 'surveyable');
    }

    public function timezone()
    {
        return $this->belongsTo(TimeZone::class);
    }

    public function isActive(): bool
    {
        return (bool) $this->statusCourses()->numActiveCourses();
    }

    public function statusCourses(): StatusCourses
    {
        $hasLingro = false;
        $hasNotLingro = false;
        $numActiveCourses = 0;

        foreach ($this->course as $course) {
            if ($course->isActive()) {
                $numActiveCourses++;

                if ($course->isLingro()) {
                    $hasLingro = true;
                } else {
                    $hasNotLingro = true;
                }
            }
        }

        $statusLingro = new StatusLingro($hasLingro, $hasNotLingro);

        return new StatusCourses($statusLingro, $numActiveCourses);
    }

    public function hasInternalComment(): bool
    {
        if (is_null($this->internal_comment)) {
            return false;
        }

        return ! empty($this->internal_comment);
    }
}
