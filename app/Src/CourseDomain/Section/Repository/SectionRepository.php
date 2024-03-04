<?php

namespace App\Src\CourseDomain\Section\Repository;

use App\Src\CourseDomain\Section\Model\Section;
use App\Src\Shared\Repository\BuilderRepository;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;

class SectionRepository
{
    private BuilderRepository $builderRepository;

    public function __construct(BuilderRepository $builderRepository)
    {
        $this->builderRepository = $builderRepository;
    }

    public static function findTrashed(int $id){
        return Section::withTrashed()->find($id);
    }

    public function obtainSectionFromInstructor(User $instructor)
    {
        return Section::query()
            ->with($this->relations())
            ->where('instructor_id', $instructor->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function obtainSectionFromTeacherAssistant(User $instructor)
    {
        return Section::query()
            ->with($this->relations())
            ->whereHas('teachingAssistant', function ($query) use ($instructor) {
                $query->where('teacher_id', $instructor->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findByCode(string $code)
    {
        return Section::query()
            ->where('code', $code)
            ->first();
    }

    public function search(CriteriaSearch $criteria)
    {
        $query = Section::query()
            ->with($this->relations());

        if ($criteria->searchBy('course_id')) {
            $query->where('course_id', '=', $criteria->searchBy('course_id'));
        }

        return $query->orderBy('created_at', 'asc')->paginate(config('linguameeting.items_per_page'));
    }

    public function obtainCourseFromMultipleCourses(Collection $coursesIds, array $relations = null)
    {
        $query = Section::query();

        isset($relations) ? $query->with($relations) : $query->with($this->relations());

        return $query->whereIn('course_id', $coursesIds)
            ->orderBy('name')
            ->get();
    }

    public function relations(): array
    {
        return [
            'course',
            'course.university',
            'documentation',
            'instructor',
            'assignment',
            'assignment.chapter',
            'assignment.file',
            'assignment.guide',
            'teachingAssistant',
        ];
    }
}
