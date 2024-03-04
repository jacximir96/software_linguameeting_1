<?php

namespace App\Src\ExperienceDomain\ExperienceComment\Action;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceComment\Model\ExperienceComment;
use App\Src\ExperienceDomain\ExperienceComment\Request\CreateCommentRequest;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;

class CreateCommentAction
{
    public function handle(CreateCommentRequest $request, Experience $experience, User $user): ExperienceComment
    {

        $comment = new ExperienceComment();
        $comment->experience_id = $experience->id;
        $comment->user_id = $user->id;

        $comment->comment = $request->comment;
        $comment->stars = $request->rate();

        $comment->commented_at = Carbon::now();

        $comment->save();

        return $comment;
    }
}
