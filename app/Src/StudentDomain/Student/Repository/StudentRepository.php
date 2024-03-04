<?php

namespace App\Src\StudentDomain\Student\Repository;

use App\Src\Shared\Repository\BuilderRepository;
use App\Src\Shared\Repository\SearchRepository;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\Shared\Service\OrderListing;
use App\Src\UserDomain\User\Model\User;

class StudentRepository implements SearchRepository
{
    private BuilderRepository $builderRepository;

    public function __construct(BuilderRepository $builderRepository)
    {

        $this->builderRepository = $builderRepository;
    }

    public function obtainStudentsForIndex()
    {
        return User::query()
            ->role(config('linguameeting.user.roles.ids.student'))
            ->orderBy('created_at', 'DESC')
            ->paginate(config('linguameeting.items_per_page'));
    }

    public function search(CriteriaSearch $criteria, OrderListing $orderListing)
    {
        $query = User::query()
            ->with($this->relations());

        $query = $this->builderRepository->buildSimpleWhereLike($query, $criteria, 'name', 'lastname', 'email');

        $query = $this->builderRepository->buildWhereByUserStatus($query, $criteria);

        $query = $this->builderRepository->buildWhereByRol($query, $criteria, config('linguameeting.user.roles.ids.student'));

        if ($criteria->hasValue('is_lingro')) {

            $value = (int) $criteria->get('is_lingro');
            $query->whereHas('enrollment.section.course', function ($query) use ($value) {
                $query->where('is_lingro', $value);
            });
        }

        if ($criteria->searchBy('class_code')) {
            $query->whereHas('enrollment.section', function ($query) use ($criteria) {
                $query->where('code', 'LIKE', '%'.$criteria->get('class_code').'%');
            });
        }

        if ($criteria->searchByMultiple('course_id')) {

            $query->where(function ($query) use ($criteria) {

                $query->whereHas('enrollment.section', function ($query) use ($criteria) {
                    $query->whereIn('course_id', $criteria->getMultiple('course_id'));
                });
            });
        } elseif ($criteria->searchBy('university_id')) {
            $query->whereHas('enrollment.section.course', function ($query) use ($criteria) {
                $query->whereIn('university_id', collect($criteria->get('university_id')));
            });
        }

        if ($orderListing) {
            $query = $query->orderBy($orderListing->field(), $orderListing->direction());
        } else {
            $query->orderBy('lastname')->orderBy('name');
        }

        if ($criteria->hasPaginate()) {
            return $query->paginate(config('linguameeting.items_per_page'));
        }

        return $query->get();
    }

    public function relations(): array
    {
        return [
            'enrollment',
            'enrollment.accommodation',
            'enrollment.section',
            'enrollment.section.instructor',
            'enrollment.section.course',
            'enrollment.section.course.university',
            'enrollment.status',
            'enrollment.enrollmentOrigin',
            'enrollment.enrollmentTarget',
            'timezone',
            'university',
        ];
    }
}
