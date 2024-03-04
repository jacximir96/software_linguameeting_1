<?php

namespace App\Src\CourseDomain\Assignment\Model;

use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\CourseDomain\AssignmentChapter\Model\AssignmentChapter;
use App\Src\CourseDomain\AssignmentFile\Model\AssignmentFile;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Assignment extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'assignment';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function week()
    {
        return $this->belongsTo(CoachingWeek::class, 'week_id');
    }

    public function guide()
    {
        return $this->belongsTo(ConversationGuide::class);
    }

    public function chapter()
    {
        return $this->hasOne(AssignmentChapter::class, 'assignment_id');
    }

    public function file()
    {
        return $this->hasOne(AssignmentFile::class, 'assignment_id');
    }

    public function isWeek(): bool
    {
        return ! is_null($this->week_id);
    }

    public function isFlex(): bool
    {
        return ! $this->isWeek();
    }

    public function hasActivityDescription(): bool
    {
        return ! empty(trim($this->activity_description));
    }

    public function isGuideFilled(): bool
    {
        return ! is_null($this->chapter);
    }

    public function isAssignmentFilled(): bool
    {
        return ! is_null($this->file);
    }

    public function isSame(self $assignment): bool
    {
        return $this->id == $assignment->id;
    }

    public function isSameSessionOrder(int $otherSessionOrder): bool
    {
        return $this->session_order == $otherSessionOrder;
    }

    public function isSessionOrder(SessionOrder $sessionOrder):bool{

        if ($this->isWeek()){
            return $this->week->sessionOrderObject()->isSame($sessionOrder);
        }

        return $this->session_order == $sessionOrder->get();
    }

    public function hasContent(): bool
    {

        if ($this->chapter) {
            return true;
        }

        return $this->hasCustomContent();
    }

    public function hasCustomContent(): bool
    {

        if ($this->file) {
            return true;
        }

        if ($this->hasActivityDescription()) {
            return true;
        }

        return false;

    }

    public function hasCoachNote(): bool
    {
        return ! empty(trim($this->coach_note));
    }
}
