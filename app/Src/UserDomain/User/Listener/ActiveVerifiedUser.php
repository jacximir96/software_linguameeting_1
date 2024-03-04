<?php


namespace App\Src\UserDomain\User\Listener;


use Illuminate\Auth\Events\Verified;

class ActiveVerifiedUser
{

    public function handle(Verified $event){

        $user = $event->user;
        
        $user->active = 1;
        $user->save();

    }
}
