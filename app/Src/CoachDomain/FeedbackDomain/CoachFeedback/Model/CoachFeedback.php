<?php

namespace App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Model;

use App\Src\Localization\Language\Model\Language;
use App\Src\Shared\Model\HashIdable;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

//linguameeting -> coach 7 (selectores)
class CoachFeedback extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    protected $table = 'coach_feedback';

    protected $dates = ['moment', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'feedbacks' => 'array',
    ];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function hasRecordingUrl(): bool
    {
        return ! empty($this->recording_url);
    }

    public function hasObservations(): bool
    {
        return ! empty(trim($this->observations));
    }

    public function isSpanish ():bool{
        return $this->language->isSpanish();
    }
}
