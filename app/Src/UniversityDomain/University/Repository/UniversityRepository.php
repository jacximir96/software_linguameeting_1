<?php

namespace App\Src\UniversityDomain\University\Repository;

use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\CourseDomain\Course\Service\Status\ActiveStatus;
use App\Src\Localization\Country\Model\Country;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\Shared\Service\OrderListing;
use App\Src\UniversityDomain\University\Model\University;

class UniversityRepository
{
    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function obtainUniversitesForIndex()
    {
        return University::with($this->relations())
            ->orderBy('name')
            ->paginate(config('linguameeting.items_per_page'));
    }

    public function obtainUniversitesForCountry(Country $country)
    {
        return University::with($this->relations())
            ->where('country_id', $country->id)
            ->orderBy('name')
            ->paginate(config('linguameeting.items_per_page'));
    }

    public function search(CriteriaSearch $criteria, OrderListing $orderListing)
    {
        $query = University::query()
            ->with($this->relations());

        if ($criteria->searchBy('name')) {
            $query->where('name', 'LIKE', '%'.$criteria->get('name').'%');
        }

        if ($criteria->searchBy('country_id')) {
            $query->where('country_id', $criteria->get('country_id'));
        }

        if ($criteria->searchBy('timezone_id')) {
            $query->where('timezone_id', $criteria->get('timezone_id'));
        }

        if ($criteria->searchBy('lingro')) {
            $query->whereHas('course', function ($query) {
                $statusCourse = new ActiveStatus();
                $this->courseRepository->filterByStatus($query, $statusCourse);
            })
                ->whereHas('course', function ($query) {
                    $query->where('is_lingro', 1);
                });
        }

        if ($criteria->searchBy('status')) {
            if ($criteria->searchActive()) {
                $query->whereHas('course', function ($query) {
                    $statusCourse = new ActiveStatus();
                    $this->courseRepository->filterByStatus($query, $statusCourse);
                });
            } elseif ($criteria->searchDeactivated()) {
                $query->whereDoesntHave('course', function ($query) {
                    $statusCourse = new ActiveStatus();
                    $this->courseRepository->filterByStatus($query, $statusCourse);
                });
            } elseif ($criteria->searchByCustomStatus(config('lingua_status.university.removed'))) {
                $query->onlyTrashed();
            }
        }

        $query->orderBy($orderListing->field(), $orderListing->direction());

        if ($criteria->hasPaginate()) {
            return $query->paginate(config('linguameeting.items_per_page'));
        }

        return $query->get();

    }

    public function relations(): array
    {
        return [
            'country',
            'course',
            'course.coachingWeek',
            'course.section',
            'experience',
            'level',
            'survey',
            'timezone',
        ];
    }
}
