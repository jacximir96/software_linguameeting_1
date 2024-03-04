<?php

namespace App\Src\UserDomain\User\Action\Command;

use App\Src\UserDomain\User\Model\User;
use App\Src\UserDomain\User\Request\UpdateProfileRequest;

class ProcessCommonProfileCommand
{
    public function handle(UpdateProfileRequest $request, User $user): User
    {
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->country_id = $request->country_id;
        $user->timezone_id = $request->timezone_id;

        $user->email = $request->email;
        $user->phone = $request->phone ?? '';
        $user->whatsapp = $request->whatsapp ?? '';

        if ($request->filled('password')) {
            $user->password = $request->password;
        }

        $user->email_reception = $request->email_reception;
        $user->email_marketing = $request->email_marketing;

        $user->save();

        return $user;
    }
}
