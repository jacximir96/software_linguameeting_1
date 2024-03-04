<?php

namespace App\Src\CoachDomain\FeedbackDomain\FeedbackSuggestion\Model;

use App\Src\CoachDomain\FeedbackDomain\FeedbackSubtype\Model\FeedbackSubtype;
use App\Src\CoachDomain\FeedbackDomain\FeedbackType\Model\FeedbackType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class FeedbackSuggestion extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'feedback_suggestions';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function subtype()
    {
        return $this->belongsTo(FeedbackSubtype::class, 'subtype_id');
    }

    public function type()
    {
        return $this->belongsTo(FeedbackType::class, 'type_id');
    }
}
