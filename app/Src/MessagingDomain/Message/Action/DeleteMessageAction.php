<?php

namespace App\Src\MessagingDomain\Message\Action;

use App\Src\MessagingDomain\Message\Model\Message;
use App\Src\MessagingDomain\Message\Service\MessageDeletionStrategy;
use App\Src\UserDomain\User\Model\User;

class DeleteMessageAction
{
    private MessageDeletionStrategy $messageDeletionStrategy;

    public function __construct(MessageDeletionStrategy $messageDeletionStrategy)
    {
        $this->messageDeletionStrategy = $messageDeletionStrategy;
    }

    public function handle(Message $message, User $userWantDelete): Message
    {

        $this->messageDeletionStrategy->checkCanBeDeleted($message, $userWantDelete);

        $message->delete();

        return $message;
    }
}
