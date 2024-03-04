<?php

namespace App\Src\MessagingDomain\Thread\Service;

use App\Src\MessagingDomain\Thread\Model\Thread;
use App\Src\Shared\Service\BaseSearchForm;

class ReplyThreadForm extends BaseSearchForm
{
    public function config(Thread $thread)
    {

        $this->action = route('post.common.messaging.thread.reply', $thread->hashId());

        $this->model = [];
    }
}
