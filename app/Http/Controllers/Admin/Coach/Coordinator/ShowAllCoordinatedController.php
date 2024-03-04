<?php

namespace App\Http\Controllers\Admin\Coach\Coordinator;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\CoachCoordinator\Repository\CoachCoordinatorRepository;
use App\Src\UserDomain\User\Model\User;


class ShowAllCoordinatedController extends Controller
{

    /**
     * @var CoachCoordinatorRepository
     */
    private CoachCoordinatorRepository $coachCoordinatorRepository;

    public function __construct (CoachCoordinatorRepository $coachCoordinatorRepository){

        $this->coachCoordinatorRepository = $coachCoordinatorRepository;
    }

    public function __invoke(User $coach)
    {
        $coordinated = $this->coachCoordinatorRepository->obtainCoordinatedFromCoordinatorWithPagination($coach);

        view()->share([
            'coach' => $coach,
            'coordinated' => $coordinated
        ]);

        return view('admin.coach.card.coordinator_of_show_all');
    }
}
