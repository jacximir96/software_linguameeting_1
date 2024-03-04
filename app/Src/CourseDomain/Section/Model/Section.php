<?php

namespace App\Src\CourseDomain\Section\Model;

use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\CourseDomain\Assignment\Service\StatusAssignment;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Course\Model\Course;

use App\Src\CourseDomain\SectionTeachingAssistant\Model\SectionTeachingAssistant;
use App\Src\Shared\Model\HashIdable;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Section extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    const KEY_PATH_INSTRUCTIONS = 'section-instructions';

    const MORPH = 'course_section';

    protected $table = 'section';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function course()
    {
        return $this->belongsTo(Course::class)->withTrashed();
    }

    public function documentation()
    {
        return $this->hasMany(Assignment::class);
    }

    public function enrollment()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function guide()
    {
        return $this->belongsTo(ConversationGuide::class)->whithTrashed();
    }

    public function instructor()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function assignment()
    {
        return $this->hasMany(Assignment::class);
    }

    public function teachingAssistant()
    {
        return $this->hasMany(SectionTeachingAssistant::class, 'section_id');
    }

    public function assignments()
    {

        $isFlex = $this->course->isFlex();

        return $this->assignment->filter(function ($assignment) use ($isFlex) {

            if ($isFlex and $assignment->isFlex()) {
                if ($assignment->hasContent()) {
                    return $assignment;
                }
            } elseif (! $isFlex and ! $assignment->isFlex()) {
                if ($assignment->hasContent()) {
                    return $assignment;
                }
            }

        })->sortBy(function ($assignment) {
            if ($assignment->isFlex()) {
                return $assignment->session_order;
            }

            return $assignment->week->session_order;
        });
    }

    public function instructionsFilename(): string
    {
        return 'section_instructions_'.$this->code.'.pdf';
    }

    public function isFree(): bool
    {
        return $this->is_free;
    }

    public function isSame(Section $otherSection): bool
    {
        return $this->id == $otherSection->id;
    }

    public function isSameId(int $id): bool
    {
        return $this->id == $id;
    }

    public function withAssignment(): bool
    {

        foreach ($this->assignment as $assignment) {
            if ($assignment->chapter) {
                return true;
            }
        }

        return false;

    }

    public function withGuide(): bool
    {

        foreach ($this->assignment as $assignment) {
            if ($assignment->chapter) {
                return true;
            }
        }

        return false;
    }

    public function statusAssignment(): StatusAssignment
    {

        $total = $this->course->conversationPackage->number_session;

        $courseIsFlex = $this->course->isFlex();
        $completed = 0;
        foreach ($this->assignment as $assignment) {

            if ($courseIsFlex and $assignment->isWeek()) {
                continue;
            }
            if (! $courseIsFlex and $assignment->isFlex()) {
                continue;
            }

            if ($assignment->hasContent()) {
                $completed++;
            }
        }

        return new StatusAssignment($total, $completed);
    }

    public function hasAssignmentsInWeek(CoachingWeek $coachingWeek): bool
    {

        $assignments = $this->assignment;

        if (! $assignments->count()) {
            return false;
        }

        foreach ($assignments as $assignment) {

            $assignmentWeek = $assignment->week;

            if ($assignmentWeek) {
                if ($assignmentWeek->isSame($coachingWeek)) {
                    return $assignment->hasCustomContent();
                }
            }
        }

        return false;
    }

    public function hasAssignmentsInFlex(int $sessionOrder): bool
    {

        $assignments = $this->assignment;

        if (! $assignments->count()) {
            return false;
        }

        foreach ($assignments as $assignment) {

            if ($assignment->isSameSessionOrder($sessionOrder)) {
                return $assignment->hasCustomContent();
            }
        }

        return false;
    }

    public function studentsCanSeeRecording():bool{
        return (bool)$this->see_recordings;
    }

    public function summaryFilename(): string
    {
        return $this->name.' Section Summary.pdf';
    }

    public function morphType(): string
    {
        return self::MORPH;
    }
}
