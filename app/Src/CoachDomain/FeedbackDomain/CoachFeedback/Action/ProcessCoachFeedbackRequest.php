<?php

namespace App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Action;

use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Model\CoachFeedback;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Request\CoachFeedbackRequest;

class ProcessCoachFeedbackRequest
{
    public function handle(CoachFeedbackRequest $request, CoachFeedback $coachFeedback): CoachFeedback
    {

        $coachFeedback->language_id = $request->language_id;
        $coachFeedback->recording_url = $request->recording_url;

        $feedbacks = [];
        if ($request->has('observations')){
            foreach ($request->observations as $typeKey => $observation) {
                $subtypes = [];
                foreach ($observation as $subtypeKey => $data) {

                    $feedback = [
                        'suggestion' => $request['suggestions'][$typeKey][$subtypeKey] ?? 0,
                        'id_sub_feed' => $subtypeKey,
                        'observation' => $request['observations'][$typeKey][$subtypeKey] ?? 0,
                        'alternative_text' => $request['alternatives_text'][$typeKey][$subtypeKey] ?? '',
                    ];

                    $subtypes[$subtypeKey] = $feedback;
                }

                $type = [
                    'id_feed' => $typeKey,
                    'subtypes' => $subtypes,
                ];

                $feedbacks[$typeKey] = $type;
            }
        }


        $coachFeedback->feedbacks = $feedbacks;
        $coachFeedback->observations = $request->observations_text ?? '';
        $coachFeedback->save();

        return $coachFeedback;

    }
}
