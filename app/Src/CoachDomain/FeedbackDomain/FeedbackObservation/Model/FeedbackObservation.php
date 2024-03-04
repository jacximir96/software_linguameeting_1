<?php

namespace App\Src\CoachDomain\FeedbackDomain\FeedbackObservation\Model;

use App\Src\CoachDomain\FeedbackDomain\FeedbackSubtype\Model\FeedbackSubtype;
use App\Src\CoachDomain\FeedbackDomain\FeedbackType\Model\FeedbackType;
use App\Src\Localization\Language\Model\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class FeedbackObservation extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'feedback_observations';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function subtype()
    {
        return $this->belongsTo(FeedbackSubtype::class, 'subtype_id');
    }

    public function type()
    {
        return $this->belongsTo(FeedbackType::class, 'type_id');
    }

    public function titleByLanguage(Language $language):string{
        return $language->isSpanish() ? $this->es_title : $this->eng_title;
    }
}
