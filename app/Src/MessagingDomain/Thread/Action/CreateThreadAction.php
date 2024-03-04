<?php

namespace App\Src\MessagingDomain\Thread\Action;

use App\Src\ExperienceDomain\ExperienceFile\Action\Command\DeleteFileCommand;
use App\Src\File\Command\UploadLocalFileCommand;
use App\Src\MessagingDomain\File\Model\MessageFile;
use App\Src\MessagingDomain\Message\Model\Message;
use App\Src\MessagingDomain\Participant\Model\Participant;
use App\Src\MessagingDomain\Thread\Model\Thread;
use App\Src\MessagingDomain\Thread\Request\ThreadRequest;
use App\Src\MessagingDomain\ThreadRead\Action\Command\MarkThreadAsReadCommand;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;

class CreateThreadAction
{
    //construct
    private UploadLocalFileCommand $uploadLocalFileCommand;

    private DeleteFileCommand $deleteFileCommand;

    private MarkThreadAsReadCommand $markThreadAsReadCommand;

    //status
    private ThreadRequest $request;

    private User $userCreator;

    private Thread $thread;

    private Message $message;

    public function __construct(UploadLocalFileCommand $uploadLocalFileCommand, DeleteFileCommand $deleteFileCommand, MarkThreadAsReadCommand $markThreadAsReadCommand)
    {

        $this->uploadLocalFileCommand = $uploadLocalFileCommand;
        $this->deleteFileCommand = $deleteFileCommand;
        $this->markThreadAsReadCommand = $markThreadAsReadCommand;
    }

    public function handle(ThreadRequest $request, User $userCreator): Thread
    {

        $this->initialize($request, $userCreator);

        $this->createThread();

        $this->markThreadAsRead();

        $this->createMessage();

        $this->attachParticipants();

        $this->processAttacch();

        return $this->thread;
    }

    private function initialize(ThreadRequest $request, User $userCreator)
    {
        $this->request = $request;
        $this->userCreator = $userCreator;
    }

    private function createThread()
    {

        $this->thread = new Thread();
        $this->thread->writer_id = $this->userCreator->id;
        $this->thread->subject = $this->request->subject;

        $this->thread->save();
    }

    private function markThreadAsRead()
    {

        $this->markThreadAsReadCommand->handle($this->thread, $this->userCreator);
    }

    private function createMessage()
    {

        $this->message = new Message();
        $this->message->thread_id = $this->thread->id;
        $this->message->user_id = $this->userCreator->id;
        $this->message->write_at = Carbon::now();
        $this->message->content = $this->request->get('content');
        $this->message->save();
    }

    private function attachParticipants()
    {

        $this->attachParticipant($this->userCreator);

        foreach ($this->request->participant_id as $participantId) {

            if ($this->userCreator->id == $participantId) {
                continue;
            }

            $participant = User::find($participantId);

            $this->attachParticipant($participant);
        }
    }

    private function attachParticipant(User $user)
    {
        $participant = new Participant();
        $participant->thread_id = $this->thread->id;
        $participant->user_id = $user->id;
        $participant->save();
    }

    private function processAttacch()
    {

        if ($this->request->hasFile('thread_file')) {

            foreach ($this->request->thread_file as $threadFile) {

                $file = new MessageFile();
                $file->message_id = $this->message->id;

                $this->uploadLocalFileCommand->handle($threadFile, $file);
            }
        }
    }
}
