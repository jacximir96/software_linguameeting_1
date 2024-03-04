<?php
namespace App\Http\Controllers\Coach\Feedback\Student;


use App\Http\Controllers\Controller;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Action\MarkFavoriteAction;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Model\CoachReview;


class MarkFavoriteController extends Controller
{

    public function __invoke(CoachReview $coachReview)
    {

        $action = app(MarkFavoriteAction::class);
        $action->handle($coachReview);

        return back()->withInput();
    }
}
