<?php

namespace App\Src\StudentDomain\Student\Service;

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
        $this->action = route('post.admin.student.email.send.send');
    }
}
