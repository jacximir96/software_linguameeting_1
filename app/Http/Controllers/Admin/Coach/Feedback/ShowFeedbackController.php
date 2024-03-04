<?php

namespace App\Http\Controllers\Admin\Coach\Feedback;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Model\CoachFeedback;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Service\CoachFeedbackWrapper;
use App\Src\CoachDomain\FeedbackDomain\FeedbackObservation\Model\FeedbackObservation;
use App\Src\CoachDomain\FeedbackDomain\FeedbackSubtype\Model\FeedbackSubtype;
use App\Src\CoachDomain\FeedbackDomain\FeedbackSuggestion\Model\FeedbackSuggestion;
use App\Src\CoachDomain\FeedbackDomain\FeedbackType\Model\FeedbackType;


class ShowFeedbackController extends Controller
{
    public function __invoke(CoachFeedback $coachFeedback)
    {
        $wrapper = new CoachFeedbackWrapper($coachFeedback);

        $types = FeedbackType::all()->keyBy('id')->sortKeys();


        $observations = FeedbackObservation::all()->keyBy('id')->sortKeys();

        $suggestions = FeedbackSuggestion::all()->keyBy('id')->sortKeys();

        $subtypes = FeedbackSubtype::all()->keyBy('id')->sortKeys();

        view()->share([
            'coach' => $coachFeedback->coach,
            'observations' => $observations,
            'subtypes' => $subtypes,
            'suggestions' => $suggestions,
            'types' => $types,
            'wrapper' => $wrapper,
        ]);

        return view('admin.coach.feedback.show');
    }
}
