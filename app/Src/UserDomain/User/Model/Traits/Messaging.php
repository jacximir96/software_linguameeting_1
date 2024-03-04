<?php

namespace App\Src\UserDomain\User\Model\Traits;

use App\Src\MessagingDomain\Message\Model\Message;
use App\Src\MessagingDomain\Thread\Model\Thread;

trait Messaging
{
    public function message()
    {
        return $this->hasMany(Message::class, 'user_id');
    }

    public function thread()
    {
        return $this->hasMany(Thread::class, 'writer_id');
    }
}
