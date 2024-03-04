<?php

namespace App\Src\CourseDomain\Course\Model;

use App\Src\CoachDomain\CoachSchedule\Model\CoachSchedule;
use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\ConversationPackageDomain\Package\Model\ConversationPackage;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Course\Model\Trait\AssignmentTrait;
use App\Src\CourseDomain\Course\Model\Trait\AuditTrait;
use App\Src\CourseDomain\Course\Model\Trait\CheckStatusTrait;
use App\Src\CourseDomain\Course\Model\Trait\MakeupTrait;
use App\Src\CourseDomain\Course\Model\Trait\PeriodsTrait;
use App\Src\CourseDomain\Course\Model\Trait\PriceTrait;
use App\Src\CourseDomain\Course\Model\Trait\SurveyTrait;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\CourseDomain\Course\Service\Routes\ConversationsRoutes;
use App\Src\CourseDomain\Course\Service\Routes\ExperiencesRoutes;
use App\Src\CourseDomain\Course\Service\Routes\Routes;
use App\Src\CourseDomain\CourseCoach\Model\CourseCoach;
use App\Src\CourseDomain\CourseCoordinator\Model\CourseCoordinator;
use App\Src\CourseDomain\DenyAccess\Model\DenyAccess;
use App\Src\CourseDomain\Holiday\Model\Holiday;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\ServiceType\Model\ServiceType;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceType\Model\ExperienceType;
use App\Src\Localization\Language\Model\Language;
use App\Src\PaymentDomain\Money\Service\MoneyCast;
use App\Src\Shared\Model\HashIdable;
use App\Src\Shared\Model\ValueObject\Url;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\TimeDomain\Semester\Model\Semester;
use App\Src\UniversityDomain\Level\Model\Level;
use App\Src\UniversityDomain\University\Model\University;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use OwenIt\Auditing\Auditable;

class Course extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, SoftDeletes, Auditable, PeriodsTrait, AssignmentTrait, CheckStatusTrait, AuditTrait, PriceTrait, MakeupTrait, SurveyTrait, HashIdable;

    const UNLIMITED_NUMBER_MAKEUPS = 10;

    const MORPH = 'course';

    protected $table = 'course';

    protected $dates = ['start_date', 'end_date', 'closed_date', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'discount' => MoneyCast::class,
    ];

    public function coordinator()
    {
        return $this->hasMany(CourseCoordinator::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id')->withTrashed();
    }

    public function conversationPackage()
    {
        return $this->belongsTo(ConversationPackage::class);
    }

    public function courseCoach()
    {
        return $this->hasMany(CourseCoach::class);
    }

    public function coachingWeek()
    {
        return $this->hasMany(CoachingWeek::class);
    }

    public function coachSchedule()
    {
        return $this->hasMany(CoachSchedule::class);
    }

    public function denyAccess()
    {
        return $this->hasMany(DenyAccess::class);
    }

    public function enrollment()
    {
        return $this->hasManyThrough(Enrollment::class, Section::class);
    }

    public function experience (){
        return $this->hasMany(Experience::class);
    }

    public function experienceType()
    {
        return $this->belongsTo(ExperienceType::class);
    }

    public function holiday()
    {
        return $this->hasMany(Holiday::class);
    }

    public function conversationGuide()
    {
        return $this->belongsTo(ConversationGuide::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function section()
    {
        return $this->hasMany(Section::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function session()
    {
        return $this->hasMany(Session::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function allowsFullEdition(User $user): bool
    {
        if ($user->hasAdminRoles()) {
            return true;
        }

        if ($this->hasAlreadyStarted()) {
            return false;
        }

        if ($this->hasStudents()) {
            return false;
        }

        return true;
    }

    public function hasStudents(): bool
    {
        return $this->enrollment()->count();
    }

    public function sectionsOrdered()
    {
        $sections = $this->section->sortBy(function ($section) {
            return $section->name;
        }, SORT_NATURAL | SORT_FLAG_CASE);

        return $sections;
    }

    public function isSame(Course $otherCourse): bool
    {
        return $this->id == $otherCourse->id;
    }

    public function isSameId(int $otherId): bool
    {
        return $this->id == $otherId;
    }


    public function summaryFilename(): string
    {
        return $this->name.' Course Summary.pdf';
    }

    public function courseCoachSorted(): Collection
    {
        return $this->courseCoach->sortBy(function ($item) {
            return $item->coach->writeFullName();
        });
    }

    public function routes(): Routes
    {

        if ($this->serviceType->isExperiences()) {
            return new ExperiencesRoutes($this->id);
        }

        return new ConversationsRoutes($this->id);
    }

    public function editUrl(): Url
    {
        return $this->routes()->editUrl();
    }

    public function morphType(): string
    {
        return self::MORPH;
    }

    public function scopeActive(Builder $query): void
    {
        $courseRepository = app(CourseRepository::class);

        $courseRepository->filterActives($query);

    }
}
