<?php

namespace App\Src\MessagingDomain\Thread\Action;

use App\Src\ExperienceDomain\ExperienceFile\Action\Command\DeleteFileCommand;
use App\Src\File\Command\UploadLocalFileCommand;
use App\Src\MessagingDomain\File\Model\MessageFile;
use App\Src\MessagingDomain\Message\Model\Message;
use App\Src\MessagingDomain\Thread\Model\Thread;
use App\Src\MessagingDomain\Thread\Request\ThreadReplyRequest;
use App\Src\MessagingDomain\ThreadRead\Action\Command\MarkThreadAsReadCommand;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;

class ReplyThreadAction
{
    //construct
    private UploadLocalFileCommand $uploadLocalFileCommand;

    private DeleteFileCommand $deleteFileCommand;

    private MarkThreadAsReadCommand $markThreadAsReadCommand;

    //status
    private ThreadReplyRequest $request;

    private User $userCreator;

    private Thread $thread;

    private Message $message;

    public function __construct(UploadLocalFileCommand $uploadLocalFileCommand, DeleteFileCommand $deleteFileCommand, MarkThreadAsReadCommand $markThreadAsReadCommand)
    {
        $this->uploadLocalFileCommand = $uploadLocalFileCommand;
        $this->deleteFileCommand = $deleteFileCommand;
        $this->markThreadAsReadCommand = $markThreadAsReadCommand;
    }

    public function handle(ThreadReplyRequest $request, Thread $thread, User $userCreator): Thread
    {

        $this->initialize($request, $thread, $userCreator);

        $this->createMessage();

        $this->markThreadAsUnreadForAll();

        $this->markThreadAsReadForWriter();

        $this->processAttacch();

        return $this->thread;
    }

    private function initialize(ThreadReplyRequest $request, Thread $thread, User $userCreator)
    {
        $this->request = $request;
        $this->thread = $thread;
        $this->userCreator = $userCreator;
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

    private function markThreadAsUnreadForAll()
    {
        //aquí, quitar todos los read_at
        $this->thread->read()->delete();
    }

    private function markThreadAsReadForWriter()
    {
        $this->markThreadAsReadCommand->handle($this->thread, $this->userCreator);
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
