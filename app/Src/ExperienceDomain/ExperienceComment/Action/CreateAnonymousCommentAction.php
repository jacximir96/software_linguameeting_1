<?php

namespace App\Src\ExperienceDomain\ExperienceComment\Action;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceComment\Model\ExperienceComment;
use App\Src\ExperienceDomain\ExperienceComment\Request\AnonymousRateExperienceRequest;
use Carbon\Carbon;

class CreateAnonymousCommentAction
{
    public function handle(AnonymousRateExperienceRequest $request, Experience $experience): ExperienceComment
    {

        $comment = new ExperienceComment();
        $comment->experience_id = $experience->id;
        $comment->name = $request->name;
        $comment->lastname = $request->lastname;
        $comment->email = $request->email;

        $comment->comment = $request->comment;
        $comment->stars = $request->rate();

        $comment->commented_at = Carbon::now();

        $comment->save();

        return $comment;
    }
}
