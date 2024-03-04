<?php

namespace App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReviewOption\Model;

use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Model\CoachReview;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\ReviewOption\Model\ReviewOption;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

class CoachReviewOption extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, SoftDeletes, Auditable;

    protected $table = 'coach_review_option';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function coachReview()
    {
        return $this->belongsTo(CoachReview::class);
    }

    public function option()
    {
        return $this->belongsTo(ReviewOption::class, 'review_option_id')->withTrashed();
    }
}
