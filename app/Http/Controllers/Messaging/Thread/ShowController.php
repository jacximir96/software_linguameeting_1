<?php
namespace App\Http\Controllers\Messaging\Thread;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\MessagingDomain\Message\Service\MessageDeletionStrategy;
use App\Src\MessagingDomain\ThreadRead\Action\Command\MarkThreadAsReadCommand;
use App\Src\MessagingDomain\Thread\Model\Thread;
use App\Src\MessagingDomain\Thread\Presenter\Breadcrumb\Coach\ShowThreadBreadcrumb;
use App\Src\MessagingDomain\Thread\Repository\ThreadRepository;
use App\Src\MessagingDomain\Thread\Service\ReplyThreadForm;
use App\Src\Shared\Model\ValueObject\Url;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShowController extends Controller
{

    use Breadcrumable;

    private ThreadRepository $threadRepository;

    public function __construct (ThreadRepository $threadRepository){

        $this->threadRepository = $threadRepository;
    }

    public function __invoke(Thread $thread)
    {

        try{

            $thread->load($this->threadRepository->relation());

            DB::beginTransaction();
            $action = app(MarkThreadAsReadCommand::class);
            $action->handle($thread, user());

            $replyForm = app(ReplyThreadForm::class);
            $replyForm->config($thread);


            $breadcrumbUrl = $this->obtainBreadcrumUrl($thread, user());
            $breadcrumb = new ShowThreadBreadcrumb($breadcrumbUrl);
            $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

            $messageDeletionStrategy = app(MessageDeletionStrategy::class);

            DB::commit();

            view()->share([
                'messageDeletionStrategy' => $messageDeletionStrategy,
                'replyForm' => $replyForm,
                'timezone' => $this->userTimezone(),
                'thread' => $thread,
                'user' => user(),
            ]);

            return view('messaging.thread_show');

        }
        catch (\Throwable $exception){

            DB::rollback();

            Log::error('There is an error when show thread.', [
                'thread' => $thread,
                'exception' => $exception,
            ]);

            flash('Error show thread')->error();

            return back();
        }
    }

    private function obtainBreadcrumUrl (Thread $thread, User $user):Url{


        if ($user->isCoach()){
            return new Url(route('get.coach.messaging.index'));
        }

        if ($thread->isOwner($user)){
            return new Url(route('get.admin.messaging.sent.index'));
        }

        return new Url(route('get.admin.messaging.inbox.index'));
    }
}
