<?php

namespace App\Src\InstructorDomain\Dashboard\Presenter;

use App\Src\Shared\Service\CriteriaSearch;
use App\Src\TimeDomain\Date\Service\PeriodsBuilder;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;

class DashboardPresenter
{
    //construct
    private PeriodsBuilder $periodsBuilder;

    //status
    private User $instructor;

    public function __construct(PeriodsBuilder $periodsBuilder)
    {
        $this->periodsBuilder = $periodsBuilder;
    }

    public function handle(User $instructor)
    {

        $this->initialize($instructor);

        return new DashboardResponse();
    }

    private function initialize(User $instructor)
    {
        $this->instructor = $instructor;
    }

    private function obtainNotReadNotifications(): Notifications
    {

        
    }

    private function obtainThreadsNotRead(): Messaging
    {


    }

}
