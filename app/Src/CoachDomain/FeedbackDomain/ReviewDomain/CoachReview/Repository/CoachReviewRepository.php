<?php

namespace App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Repository;

use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Model\CoachReview;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service\ReviewsStats;
use App\Src\Shared\Repository\BuilderRepository;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\Shared\Service\OrderListing;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Builder;

class CoachReviewRepository
{
    private BuilderRepository $builderRepository;

    public function __construct(BuilderRepository $builderRepository)
    {

        $this->builderRepository = $builderRepository;
    }

    public function reviewStats(User $coach): ReviewsStats
    {

        $average = $this->averageByCoach($coach);

        $total = $this->countByCoach($coach);

        return new ReviewsStats($total, $average);
    }

    public function averageByCoach(User $coach)
    {

        $average = CoachReview::where('coach_id', $coach->id)->average('stars');

        return $average ?? 0;
    }

    public function countByCoach(User $coach)
    {
        return CoachReview::where('coach_id', $coach->id)->count();
    }

    public function last(User $coach, int $take = 5)
    {

        return CoachReview::with($this->relations())
            ->where('coach_id', $coach->id)
            ->orderBy('id', 'desc')
            ->take($take)
            ->get();
    }

    public function obtainByCoachWithPagination(User $coach, int $size = 5)
    {

        $query = $this->buildWithRelationsAndJoins();
        $query->where('coach_review.coach_id', $coach->id);

        $query->orderBy('id', 'desc');

        return $query->paginate($size);
    }

    public function search(CriteriaSearch $criteria, OrderListing $orderListing)
    {

        $query = $this->buildWithRelationsAndJoins();

        $query = $this->builderRepository->buildSimpleWhere($query, $criteria, 'stars', 'stars');

        if ($criteria->searchBy('student')) {
            $query->whereHas('session.enrollment.user', function ($query) use ($criteria) {
                $query->where('name', 'LIKE', '%'.$criteria->get('student').'%')
                    ->orWhere('lastname', 'LIKE', '%'.$criteria->get('student').'%');
            });
        }

        if ($criteria->searchBy('coach')) {
            $query->whereHas('coach', function ($query) use ($criteria) {
                $query->where('name', 'LIKE', '%'.$criteria->get('coach').'%')
                    ->orWhere('lastname', 'LIKE', '%'.$criteria->get('coach').'%');
            });
        }

        if ($criteria->searchBy('coach_id')) {
            $query->where('coach_review.coach_id', $criteria->get('coach_id'));
        }

        if ($criteria->searchBy('university_id')) {
            $query->whereHas('enrollmentSession.enrollment.section.course', function ($query) use ($criteria) {
                $query->where('university_id', $criteria->get('university_id'));
            });
        }

        if ($criteria->searchBy('review_option_id')) {
            $query->whereHas('coachReviewOption', function ($query) use ($criteria) {
                $query->where('review_option_id', $criteria->get('review_option_id'));
            });
        }

        if ($criteria->searchBy('favorite')) {

            $searchOnlyFavorite = $criteria->get('favorite') == '1';
            $searchNoFavorite = $criteria->get('favorite') === '0';

            if ($searchOnlyFavorite) {
                $query->whereNotNull('favorited_at');
            } elseif ($searchNoFavorite) {
                $query->whereNull('favorited_at');
            }
        }

        $this->configOrder($query, $orderListing);

        if ($criteria->hasPaginate()) {
            return $query->paginate(config('linguameeting.items_per_page'));
        }

        return $query->get();
    }

    private function configOrder(Builder $query, OrderListing $orderListing)
    {

        if ($orderListing->isField('id')) {
            return $query->orderBy('id', $orderListing->direction());
        }

        if ($orderListing->isField('date')) {
            return $query->orderBy('session.day', $orderListing->direction());
        }

        if ($orderListing->isField('stars')) {
            return $query->orderBy($orderListing->field(), $orderListing->direction());
        }

        if ($orderListing->isField('coach')) {
            $query->orderBy('user.lastname', $orderListing->direction());
            $query->orderBy('user.name', $orderListing->direction());
        }

        if ($orderListing->isField('student')) {
            $query->orderBy('student.lastname', $orderListing->direction());
            $query->orderBy('student.name', $orderListing->direction());
        }

        if ($orderListing->isField('university')) {
            return $query->orderBy('university.name', $orderListing->direction());
        }

        $query->orderBy('id', 'desc');

    }

    private function buildWithRelationsAndJoins(): Builder
    {

        //joins for sort
        $query = CoachReview::with($this->relations());
        $query->select('coach_review.*');

        $query->join('enrollment_session', 'coach_review.enrollment_session_id', '=', 'enrollment_session.id');
        $query->join('session', 'enrollment_session.session_id', '=', 'session.id');

        //sort by university
        $query->join('course', 'session.course_id', '=', 'course.id');
        $query->join('university', 'course.university_id', '=', 'university.id');

        //sort by student
        $query->join('enrollment', 'enrollment_session.enrollment_id', '=', 'enrollment.id');
        $query->join('user as student', 'enrollment.student_id', '=', 'student.id');

        //sort by coach
        $query->join('user', 'coach_review.coach_id', '=', 'user.id');

        return $query;
    }

    public function relations(): array
    {
        return [
            'coach',

            'coachReviewOption',
            'coachReviewOption.option',

            'enrollmentSession.enrollment',
            'enrollmentSession.enrollment.user',

            'enrollmentSession.session',
            'enrollmentSession.session.course',
            'enrollmentSession.session.course.university',
        ];
    }
}
