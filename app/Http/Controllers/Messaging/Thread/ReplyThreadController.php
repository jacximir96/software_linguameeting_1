<?php

namespace App\Http\Controllers\Messaging\Thread;

use App\Http\Controllers\Controller;
use App\Src\MessagingDomain\Thread\Action\ReplyThreadAction;
use App\Src\MessagingDomain\Thread\Model\Thread;
use App\Src\MessagingDomain\Thread\Request\ThreadReplyRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ReplyThreadController extends Controller
{

    public function __invoke(ThreadReplyRequest $request, Thread $thread)
    {
        try {

            DB::beginTransaction();

            $action = app(ReplyThreadAction::class);
            $action->handle($request, $thread, user());

            DB::commit();

            flash(trans('messaging.thread.reply.success'))->success();

            return back();

        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when create reply in thread.', [
                'thread' => $thread,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('messaging.thread.reply.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
