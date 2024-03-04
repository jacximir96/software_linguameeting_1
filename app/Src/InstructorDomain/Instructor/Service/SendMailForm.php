<?php

namespace App\Src\InstructorDomain\Instructor\Service;

use App\Src\Shared\Service\BaseSearchForm;

class SendMailForm extends BaseSearchForm
{
    const SLUG = 'user_send_mail';

    public function __construct()
    {
        $this->usersIds = collect();
    }

    public function config()
    {
        $this->action = route('post.admin.instructor.email.send.send');
    }
}
