<?php
namespace App\Http\Controllers\Admin\Messaging;


use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\MessagingDomain\Thread\Presenter\Breadcrumb\IndexSentBreadcrumb;
use App\Src\MessagingDomain\Thread\Repository\ThreadRepository;


class IndexSentController extends Controller
{
    use Breadcrumable;

    private ThreadRepository $threadRepository;

    public function __construct (ThreadRepository $threadRepository){

        $this->threadRepository = $threadRepository;
    }

    public function __invoke()
    {

        $breadcrumb = new IndexSentBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        $threads = $this->threadRepository->obtainSent(user());


        view()->share([
            'timezone' => $this->userTimezone(),
            'threads' => $threads,
            'user' => user(),
        ]);

        return view('admin.messaging.index');
    }
}
