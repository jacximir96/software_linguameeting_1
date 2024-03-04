<?php


namespace App\Http\Controllers\Admin\Coach\Feedback;


use App\Src\CoachDomain\FeedbackDomain\FeedbackObservation\Model\FeedbackObservation;
use App\Src\CoachDomain\FeedbackDomain\FeedbackSubtype\Model\FeedbackSubtype;
use App\Src\CoachDomain\FeedbackDomain\FeedbackSuggestion\Model\FeedbackSuggestion;
use App\Src\CoachDomain\FeedbackDomain\FeedbackType\Model\FeedbackType;

trait Feedbackable
{

    public function sendCommonDataToView (){

        $observations = FeedbackObservation::all()->keyBy('id')->sortKeys();

        $suggestions = FeedbackSuggestion::all()->keyBy('id')->sortKeys();

        $types = FeedbackType::all()->keyBy('id')->sortKeys();

        $subtypes = FeedbackSubtype::all()->keyBy('id')->sortKeys();

        view()->share([
            'observations' => $observations,
            'suggestions' => $suggestions,
            'subtypes' => $subtypes,
            'types' => $types,
        ]);
    }
}
