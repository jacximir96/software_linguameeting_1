<?php

namespace App\Src\CoachDomain\FeedbackDomain\FeedbackType\Model;

use App\Src\_Old\Model\FeedbacksObservations;
use App\Src\CoachDomain\FeedbackDomain\FeedbackSubtype\Model\FeedbackSubtype;
use App\Src\CoachDomain\FeedbackDomain\FeedbackSuggestion\Model\FeedbackSuggestion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class FeedbackType extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'feedback_type';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function observation()
    {
        return $this->hasMany(FeedbacksObservations::class, 'type_id');
    }

    public function suggestion()
    {
        return $this->hasMany(FeedbackSuggestion::class, 'type_id');
    }

    public function subtype()
    {
        return $this->hasMany(FeedbackSubtype::class, 'type_id');
    }
}
