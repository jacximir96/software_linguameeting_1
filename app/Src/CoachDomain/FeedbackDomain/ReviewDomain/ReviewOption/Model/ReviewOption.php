<?php

namespace App\Src\CoachDomain\FeedbackDomain\ReviewDomain\ReviewOption\Model;

use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReviewOption\Model\CoachReviewOption;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

class ReviewOption extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, SoftDeletes, Auditable;

    protected $table = 'review_option';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function coachReviewOption()
    {
        return $this->hasMany(CoachReviewOption::class);
    }
}
