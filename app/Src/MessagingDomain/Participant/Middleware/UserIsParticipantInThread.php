<?php

namespace App\Src\MessagingDomain\Participant\Middleware;

use App\Src\MessagingDomain\Participant\Repository\ParticipantRepository;
use App\Src\MessagingDomain\Thread\Model\Thread;
use Closure;
use Illuminate\Http\Request;

class UserIsParticipantInThread
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $repo = app(ParticipantRepository::class);

        $thread = $request->thread;

        if (! $thread) {
            $message = $request->message;
            if ($message) {
                $thread = $message->thread;
            }
        }

        if (! $thread instanceof Thread) {
            abort(403);
        }

        $exists = $repo->checkParticipantExistsInTread(user(), $thread);

        if (! $exists) {
            abort(403);
        }

        return $next($request);
    }
}
