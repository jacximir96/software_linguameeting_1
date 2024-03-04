<?php


namespace App\Src\CourseDomain\SessionDomain\Session\Service;


interface SessionOrderPeriod
{
    public function sessionOrderObject():SessionOrder;

    public function hasPeriod ():bool;

    public function writeSessionNumber ():string;
}
