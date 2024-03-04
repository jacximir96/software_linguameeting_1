<?php

namespace App\Src\UserDomain\User\Action;

use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\UserDomain\User\Mail\NewRegisterMail;
use Illuminate\Support\Facades\Mail;

class SendNewRegisterEmailAction
{
    public function handle(Enrollment $enrollment)
    {
        Mail::to($enrollment->user->email)->queue((new NewRegisterMail($enrollment))->onQueue('emails'));
    }
}
