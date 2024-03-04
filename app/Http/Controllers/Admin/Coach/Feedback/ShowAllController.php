<?php

namespace App\Http\Controllers\Admin\Coach\Feedback;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Presenter\ShowAllPresenter;
use App\Src\UserDomain\User\Model\User;


class ShowAllController extends Controller
{
    public function __invoke(User $coach)
    {

        $presenter = app(ShowAllPresenter::class);
        $viewData = $presenter->handle($coach);

        view()->share([
            'coach' => $coach,
            'isShowAll' => true,
            'viewData' => $viewData,
        ]);

        return view('admin.coach.feedback.show_all');
    }
}
