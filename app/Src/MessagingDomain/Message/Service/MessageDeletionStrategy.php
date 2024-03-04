<?php

namespace App\Src\MessagingDomain\Message\Service;

use App\Src\MessagingDomain\Message\Exception\MessageIsNotLastest;
use App\Src\MessagingDomain\Message\Exception\UserIsNotOwner;
use App\Src\MessagingDomain\Message\Model\Message;
use App\Src\MessagingDomain\Message\Repository\MessageRepository;
use App\Src\UserDomain\User\Model\User;

class MessageDeletionStrategy
{
    private MessageRepository $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {

        $this->messageRepository = $messageRepository;
    }

    public function canBeDeleted(Message $message, User $userWantDelete): bool
    {

        if (! $message->isOwner($userWantDelete)) {
            return false;
        }

        $lastMessage = $this->messageRepository->getLastMessageOfThread($message->thread);

        if ($lastMessage) {
            if ($lastMessage->isSame($message)) {
                return true;
            }
        }

        return false;
    }

    public function checkCanBeDeleted(Message $message, User $userWantDelete): bool
    {

        if (! $message->isOwner($userWantDelete)) {
            throw new UserIsNotOwner();
        }

        $lastMessage = $this->messageRepository->getLastMessageOfThread($message->thread);

        if ($lastMessage) {
            if (! $lastMessage->isSame($message)) {
                throw new MessageIsNotLastest();
            }
        }

        return true;
    }
}
