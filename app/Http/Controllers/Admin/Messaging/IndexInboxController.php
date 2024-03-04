<?php
namespace App\Http\Controllers\Admin\Messaging;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\MessagingDomain\Thread\Presenter\Breadcrumb\IndexInboxBreadcrumb;
use App\Src\MessagingDomain\Thread\Repository\ThreadRepository;


class IndexInboxController extends Controller
{
    use Breadcrumable;

    private ThreadRepository $threadRepository;

    public function __construct (ThreadRepository $threadRepository){

        $this->threadRepository = $threadRepository;
    }

    public function __invoke()
    {

        $breadcrumb = new IndexInboxBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        $threads = $this->threadRepository->obtainInbox(user());

        view()->share([
            'isInbox' => true,
            'threads' => $threads,
            'user' => user(),
        ]);

        return view('admin.messaging.index');
    }

}
