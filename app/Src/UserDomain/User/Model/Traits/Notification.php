<?php


namespace App\Src\UserDomain\User\Model\Traits;


use App\Src\UserDomain\User\Mail\VerifyEmailWithPassword;
use App\Src\UserDomain\User\Notification\ResetPasswordNotification;

trait Notification
{

    public function sendEmailVerificationNotificationWithPassword(string $password)
    {
        $this->notify(new VerifyEmailWithPassword($this, $password));
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token, $this));
    }

}
