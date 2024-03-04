<?php

namespace App\Http\Controllers\Coach\Messaging;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\MessagingDomain\Thread\Presenter\Breadcrumb\Coach\IndexBreadcrumb;
use App\Src\MessagingDomain\Thread\Repository\ThreadRepository;


class IndexController extends Controller
{
    use Breadcrumable, Orderable;

    private ThreadRepository $threadRepository;

    public function __construct (ThreadRepository $threadRepository){

        $this->threadRepository = $threadRepository;
    }

    public function __invoke()
    {

        $coach = user();

        $threads = $this->threadRepository->obtainInbox(user());

        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'coach' => $coach,
            'timezone' => $this->userTimezone(),
            'threads' => $threads,
        ]);

        return view('coach.messaging.index');
    }

}
