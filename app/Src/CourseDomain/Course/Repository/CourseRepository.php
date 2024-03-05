<?php

namespace App\Src\CourseDomain\Course\Repository;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Service\Status\Status;
use App\Src\CourseDomain\Course\Service\Status\StatusFactory;
use App\Src\Shared\Repository\BuilderRepository;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\Shared\Service\OrderListing;
use App\Src\UniversityDomain\University\Model\University;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class CourseRepository
{
    private BuilderRepository $builderRepository;

    private StatusFactory $statusFactory;

    public function __construct(BuilderRepository $builderRepository, StatusFactory $statusFactory)
    {
        $this->builderRepository = $builderRepository;
        $this->statusFactory = $statusFactory;
    }

    public static function findTrashed(int $id){
        return Course::withTrashed()->find($id);
    }

    public function obtainByIds(array $ids, array $relations = null)
    {

        $query = Course::query();

        isset($relations) ? $query->with($relations) : $query->with($this->relations());

        return $query->whereIn('id', $ids)
            ->orderBy('name')
            ->get();

    }

    public function obtainCourseFromUniversity(University $university, string $orderField = 'start_date', string $orderDirection = 'DESC')
    {
        $courses = Course::query()
            ->with($this->relations())
            ->where('university_id', $university->id);

        $courses->orderBy($orderField, $orderDirection);

        return $courses->get();
    }

    public function obtainCourseFromUniversityByLanguages(University $university, array $languagesIds): Collection
    {

        return Course::query()
            ->with($this->relations())
            ->where('university_id', $university->id)
            ->whereIn('language_id', $languagesIds)
            ->orderBy('start_date', 'desc')
            ->get();
    }

    public function obtainCourseFromMultipleUniversities(Collection $universitiesIds, array $relations = null)
    {
        $query = Course::query();

        isset($relations) ? $query->with($relations) : $query->with($this->relations());

        return $query->whereIn('university_id', $universitiesIds)
            ->orderBy('name')
            ->get();
    }

    public function obtainCourseFromCourseCoordinator(User $instructor)
    {

        return Course::query()
            ->with($this->relations())
            ->whereHas('coordinator', function ($query) use ($instructor) {
                $query->where('coordinator_id', $instructor->id);
            })
            ->orderBy('name')
            ->get();
    }

    public function obtainCourseCreatedBy(User $user)
    {

        return Course::query()
            ->with($this->relations())
            ->where('creator_id', $user->id)
            ->orderBy('name')
            ->get();
    }

    public function obtainCoursesForASectionInstructor(User $instructor)
    {

        $query = Course::query()
            ->with($this->relations())
             ->withCount('enrollment')
            ->whereHas('section', function ($query) use ($instructor) {
                $query->where('instructor_id', $instructor->id);
            })
            ->orderBy('name')
            ->get();
            // dd($query);
            return $query;
            // dd($query->toSql());
            // dd($query->getBindings());

    }

    public function search(CriteriaSearch $criteria, OrderListing $orderListing = null, array $extraFlags = [])
    {
        $query = Course::query()
            ->select('course.*')
            ->with($this->relations())
            ->join('university', 'course.university_id', '=', 'university.id');

        if ($criteria->searchBy('name')) {
            $query->where('course.name', 'LIKE', '%'.$criteria->get('name').'%');
        }

        if (isset($extraFlags['withCount'])) {
            $query->withCount($extraFlags['withCount']);
        }
        if (isset($extraFlags['withSection'])) {
            $query->with('section');
        }

        $query = $this->builderRepository->buildSimpleWhere($query, $criteria, 'year', 'semester_id', 'level_id', 'language_id', 'university_id', 'service_type_id');

        if ($criteria->hasValue('is_lingro')) {
            $value = (int) $criteria->get('is_lingro');
            $query->where('is_lingro', $value);
        }

        if ($criteria->searchBy('status')) {
            $status = $this->statusFactory->buildBySlug($criteria->get('status'));
            $query = $this->filterByStatus($query, $status);
        }

        if ($criteria->hasValue('start_date')) {
            $startDate = $criteria->getDate('start_date');
            $query->where('start_date', '>=',$startDate->toDateString() );
        }

        if ($criteria->hasValue('end_date')) {
            $startDate = $criteria->getDate('end_date');
            $query->where('end_date', '<=',$startDate->toDateString() );
        }

        if ($orderListing) {

            if ($orderListing->searchByField('university')) {
                $query = $query->orderBy('university.name', $orderListing->direction());
            } else {
                $query = $query->orderBy($orderListing->field(), $orderListing->direction());
            }

        } else {
            $query->orderBy('created_at');
        }

        if ($criteria->hasPaginate()) {
            return $query->paginate(config('linguameeting.items_per_page'));
        }

        return $query->get();
    }

    public function relations(): array
    {
        return [
            'serviceType',
            'experienceType',
            'coachingWeek',
            'coordinator',
            'coordinator.person',
            'conversationPackage',
            'conversationPackage.sessionType',
            'conversationGuide',
            'conversationGuide.conversationGuideFile',
            'conversationGuide.chapter',
            'conversationGuide.chapter',
            'conversationGuide.chapter.file',
            'courseCoach',
            'courseCoach.coach',
            'courseCoach.coach.country',
            'language',
            'semester',
            'survey',
            'level',
            'university',
        ];
    }

    public function relationsWithSections(): array
    {
        $relations = $this->relations();

        $sectionRelations = [
            'section',
            'section.teachingAssistant',
            'section.assignment',
            'section.assignment.file',
            'section.assignment.chapter',
            'section.instructor',
        ];

        return array_merge($relations, $sectionRelations);
    }

    public function relationsForCalendarCoach(): array
    {

        return [
            'serviceType',
            'experienceType',
            'coachingWeek',
            'coordinator',
            'coordinator.person',
            'conversationPackage',
            'conversationPackage.sessionType',
            'university',
        ];
    }

    public function relationWithWeeksAssignments(): array
    {

        $relations = $this->relations();

        $sectionRelations = [
            'section',
            'section.teachingAssistant',
            'coachingWeek.assignment',
            'coachingWeek.assignment.file',
            'coachingWeek.assignment.chapter',
        ];

        return array_merge($relations, $sectionRelations);

    }

    public function filterByStatus(Builder $query, Status $status): Builder
    {
        if ($status->isActive()) {

            $this->filterActives($query);

        } elseif ($status->isPast()) {

            $referenceDate = Carbon::now()->subWeeks(2);

            $query->where('end_date', '<', $referenceDate->toDateString());

        } elseif ($status->isDraft()) {

            $query->where(function ($query) {
                $query->has('section', '=', 0)
                    ->orWhere(function ($query) {
                        $query->where('is_flex', 0)->doesntHave('coachingWeek');
                    });
            });
        }

        return $query;
    }

    public function filterActives(Builder $query)
    {

        $now = Carbon::now();

        $query->where(function ($query) use ($now) {

            $query->where(function ($query) use ($now) {
                $query->whereRaw("end_date >= DATE_ADD('".$now->toDateString()."', INTERVAL 14 DAY)");
            });
            $query->has('section')
                ->orWhere(function ($query) {
                    $query->where('is_flex', 1)->has('coachingWeek');
                });
        });
    }
}
