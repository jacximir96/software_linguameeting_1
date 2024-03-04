<?php

namespace App\Src\InstructorDomain\Dashboard\Presenter;


class DashboardResponse
{

    private Notifications $notifications;

    private Messaging $messaging;


    public function __construct()
    {

    }

    public function notifications(): Notifications
    {
        return $this->notifications;
    }

    public function messaging(): Messaging
    {
        return $this->messaging;
    }

}
