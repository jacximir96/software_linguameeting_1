<?php

namespace App\Src\CoachDomain\Coach\Repository;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Localization\Language\Model\Language;
use App\Src\Shared\Repository\BuilderRepository;
use App\Src\Shared\Repository\SearchRepository;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\Shared\Service\OrderListing;
use App\Src\UserDomain\User\Model\User;

class CoachRepository implements SearchRepository
{
    private BuilderRepository $builderRepository;

    public function __construct(BuilderRepository $builderRepository)
    {

        $this->builderRepository = $builderRepository;
    }

    public function obtainCoachesForLanguage(Language $language)
    {

        return User::query()
            ->with($this->relations())
            ->role(config('linguameeting.user.roles.coach'))
            ->whereHas('language', function ($query) use ($language) {
                $query->where('language.id', $language->id);
            })
            ->orderBy('lastname')
            ->orderBy('name')
            ->get();

    }

    public function obtainCoachesIdsForLanguageAndName(Language $language, string $name = ''): array
    {

        $query = User::query()
            ->select('id')
            ->role(config('linguameeting.user.roles.coach'))
            ->whereHas('language', function ($query) use ($language) {
                $query->where('language.id', $language->id);
            });

        if ( ! empty($name)){

            $query->where(function ($query) use ($name){
                $query->where('name', 'LIKE', '%'.$name.'%')
                    ->orWhere('lastname', 'LIKE', '%'.$name.'%');
            });
        }

        return $query->pluck('id')->toArray();
    }

    public function obtainCoachesForIndex()
    {
        return User::query()
            ->role(config('linguameeting.user.roles.coach'))
            ->orderBy('created_at', 'DESC')
            ->paginate(config('linguameeting.items_per_page'));
    }

    public function obtainCoachesToStatusIndex()
    {
        return User::query()
            ->role(config('linguameeting.user.roles.coach'))
            ->orderBy('lastname', 'asc')
            ->orderBy('name', 'asc')
            ->get();
    }

    public function obtainCoachesForZoomMeetingIndex()
    {
        return User::query()
            ->with('zoomUser', 'zoomMeeting')
            ->role(config('linguameeting.user.roles.coach'))
            ->orderBy('lastname')
            ->orderBy('name')
            ->get();
    }

    public function all()
    {
        return User::query()
            ->orderBy('lastname')
            ->orderBy('name')
            ->role(config('linguameeting.user.roles.coach'))
            ->get();
    }

    public function obtainCoachesForAssignToCourse(Course $course)
    {

        $query = User::query();
        $query->active();
        $query->noDemo();
        $query->role(config('linguameeting.user.roles.coach.coach'));

        $query->whereDoesntHave('courseCoach', function ($query) use ($course) {
            $query->where('course_id', $course->id);
        });

        $query->whereHas('userLanguage', function ($query) use ($course) {
            $query->where('language_id', $course->language_id);
        });

        $query->orderBy('lastname')->orderBy('name');

        return $query->get();

    }

    public function obtainCoachesWithoutCoordinator()
    {

        $query = User::query();
        $query->active();
        $query->noDemo();
        $query->role(config('linguameeting.user.roles.coach.coach'));

        $query->whereDoesntHave('coachCoordinated');
        $query->orderBy('lastname')->orderBy('name');

        return $query->get();
    }

    public function obtainCoachesCoordinators()
    {

        $query = User::query();
        $query->active();
        $query->noDemo();
        $query->role(config('linguameeting.user.roles.coach.coach_coordinator'));

        $query->orderBy('lastname')->orderBy('name');

        return $query->get();
    }

    public function obtainPayersForBilling()
    {

        return User::query()
            ->active()
            ->noDemo()
            ->with($this->billingRelations())
            ->with('coachCoordinator', 'coachCoordinator.coach', 'coachCoordinator.coach.timezone')
            ->role(config('linguameeting.user.roles.coach'))
            ->whereHas('coachInfo', function ($query) {
                return $query->where('is_payer', 1);
            })
            ->get();
    }

    public function obtainForBillingNotIncludeInIds(array $coachesIds)
    {

        return User::query()
            ->active()
            ->noDemo()
            ->with($this->billingRelations())
            ->role(config('linguameeting.user.roles.coach'))
            ->whereNotIn('id', $coachesIds)
            ->whereHas('coachInfo', function ($query) {
                return $query->where('is_payer', 0);
            })
            ->get();
    }

    public function obtainToConfigSemesterFinished()
    {

        return User::query()
            ->active()
            ->noDemo()
            ->with('semesterFinished', 'coachCoordinated')
            ->role(config('linguameeting.user.roles.coach'))
            ->whereHas('coachInfo', function ($query) {
                $query->where('is_trainee', 0);
            })
            ->has('semesterFinished')
            ->get();
    }

    public function coachWithSessionsInCourse (Course $course){

        return User::query()
            ->active()
            ->noDemo()
            // ->whereHas('session', function ($query) use ($course){
            //     $query->where('course_id', $course->id);
            // })
            ->whereHas('coaches', function ($query) use ($course){
                $query->where('course_id', $course->id);
            })
            ->orderBy('lastname')->orderBy('name')
            ->get();

            
    }

    public function search(CriteriaSearch $criteria, OrderListing $orderListing)
    {
        $query = User::query()
            ->with($this->relations());

        $query = $this->builderRepository->buildSimpleWhere($query, $criteria, 'timezone_id', 'country_id');

        $query = $this->builderRepository->buildSimpleWhereLike($query, $criteria, 'name', 'lastname', 'email');

        $query = $this->builderRepository->buildWhereByUserStatus($query, $criteria);

        $query = $this->builderRepository->buildWhereByRol($query, $criteria, config('linguameeting.user.roles.coach'));

        $query = $this->builderRepository->buildWhereByUserLanguage($query, $criteria);

        $query = $this->builderRepository->buildWhereByUserStatus($query, $criteria);

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
            'coachCoordinator',
            'coachCoordinator.coach',
            'coachInfo',
            'country',
            'evaluationManager',
            'hobby',
            'language',
            'roles',
            'timezone',
        ];
    }

    public function relationsWithCoachReview(): array
    {

        $relations = [
            'coachReview',
            'coachReview.enrollmentSession',
            'coachReview.enrollmentSession.enrollment',
            'coachReview.enrollmentSession.enrollment.user',
            'coachReview.coachReviewOption',
        ];

        return array_merge($this->relations(), $relations);
    }

    public function billingRelations(): array
    {

        return [
            'billingInfo',
            'billingInfo.accountType',
            'billingInfo.country',
            'billingInfo.currency',
            'billingInfo.methodPayment',
            'coachInfo',
            'payment',
        ];

    }
}
