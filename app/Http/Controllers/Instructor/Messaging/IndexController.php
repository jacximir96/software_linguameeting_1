<?php

namespace App\Http\Controllers\Instructor\Messaging;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\MessagingDomain\Thread\Presenter\Breadcrumb\Instructor\IndexBreadcrumb;
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

        $instructor = user();

        $threads = $this->threadRepository->obtainInbox(user());

        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'instructor' => $instructor,
            'timezone' => $this->userTimezone(),
            'threads' => $threads,
        ]);

        return view('instructor.messaging.index');
    }

}
