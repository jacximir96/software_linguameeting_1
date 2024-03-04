<?php

namespace App\Src\CoachDomain\Ranking\Action;

use App\Src\CoachDomain\Ranking\Request\RankingRequest;
use App\Src\UserDomain\User\Model\User;
use InvalidArgumentException;

class UpdateRankingAction
{
    public function handle(RankingRequest $request, User $coach, string $field)
    {

        $coachInfo = $coach->coachInfo;
        if ($field == 'ranking') {
            $coachInfo->ranking = $request->value ?? 0;
        } elseif ($field == 'preference') {
            $coachInfo->preference = $request->value ?? 0;
        } else {
            throw new InvalidArgumentException(sprintf('%f field not valid', $field));
        }

        $coachInfo->save();
    }
}
