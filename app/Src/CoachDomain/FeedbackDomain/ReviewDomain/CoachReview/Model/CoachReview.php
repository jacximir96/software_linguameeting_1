<?php

namespace App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Model;

use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReviewOption\Model\CoachReviewOption;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\Shared\Model\HashIdable;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

//valoraciones de los estudiantes a los coach
class CoachReview extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, SoftDeletes, Auditable, HashIdable;

    protected $table = 'coach_review';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function coachReviewOption()
    {
        return $this->hasMany(CoachReviewOption::class);
    }

    public function course()
    {
        return $this->session()->course;
    }

    public function enrollmentSession()
    {
        return $this->belongsTo(EnrollmentSession::class);
    }

    public function session()
    {
        return $this->enrollmentSession->session;
    }

    public function student()
    {
        return $this->enrollmentSession->enrollment->user;
    }

    public function university()
    {
        return $this->enrollmentSession->session->course->university;
    }

    public function isFavorite(): bool
    {
        return ! is_null($this->favorited_at);
    }
}
