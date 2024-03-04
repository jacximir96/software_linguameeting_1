<?php
namespace App\Src\ActivityLog\Repository;

use App\Src\ActivityLog\Model\Activity;
use App\Src\ActivityLog\Service\MomentLogin;
use App\Src\StudentDomain\Makeup\Model\Makeup;
use App\Src\StudentDomain\Makeup\Repository\MakeupRepository;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


class StudentActivityRepository
{
    //construct
    private MakeupRepository $makeupRepository;

    private Collection $activities;


    //status
    private User $student;

    private int $perPage;

    public function __construct (MakeupRepository $makeupRepository){
        $this->makeupRepository = $makeupRepository;
        $this->activities = collect();
    }

    public function obtainLastLogin (User $student):MomentLogin{

        $activity =  Activity::causedBy($student)
            ->where('description', 'activity.user.login')
            ->orderBy('id', 'desc')
            ->first();

        if ($activity){
            return new MomentLogin($activity->created_at);
        }

        return new MomentLogin();

    }

    public function obtainActivity (User $student, int $perPage = 0){

        $this->initialize($student, $perPage);

        $this->addActivitiesAsCaused();

        $this->addActivityAssignMakeup();

        $this->sortActivities();

        return $this->take($perPage);

    }

    private function initialize (User $student, int $perPage){

        $this->activities = collect();
        $this->student = $student;
        $this->perPage = $perPage;
    }


    private function addActivitiesAsCaused (){

        $activities =  Activity::causedBy($this->student)
            ->orderBy('id', 'desc')
            ->get();

        $this->addActivities($activities);

        //hack para obtener únicamente la actividad de creación
        $activities =  Activity::forSubject($this->student)
            ->where('causer_id', '!=', $this->student->id)
            ->orderBy('id', 'desc')
            ->get();

        $this->addActivities($activities);
    }

    private function addActivityAssignMakeup (){

        $makeupsIds = $this->makeupRepository->obtainIdsByStudent($this->student);

        $activities =  Activity::query()
            ->where('subject_type', Makeup::MORPH)
            ->whereIn('subject_id', $makeupsIds)
            ->orderBy('id', 'desc')
            ->get();

        $this->addActivities($activities);

    }

    private function sortActivities (){

        $this->activities = $this->activities->sortByDesc(function ($item){
            return $item->id;
        });
    }

    private function take (int $perPage):LengthAwarePaginator{

        if ($perPage == 0){
            $perPage = $this->activities->count();
        }

        //crear paginación manual
        $currentPage = request()->get('page', 1);
        $startIndex = ($currentPage - 1) * $perPage;

        $currentPageItems = $this->activities->slice($startIndex, $perPage);

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            $this->activities->count(), // Número total de elementos
            $perPage,
            $currentPage,
            ['path' => url()->current()]
        );
    }

    private function addActivities (Collection $activities){

        foreach ($activities as $item){

            if ($this->activities->has($item->id)){
                continue;
            }
            $this->activities->put($item->id, $item);
        }
    }
}
