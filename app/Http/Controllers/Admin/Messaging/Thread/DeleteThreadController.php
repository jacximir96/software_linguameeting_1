<?php

namespace App\Http\Controllers\Admin\Messaging\Thread;

use App\Http\Controllers\Controller;
use App\Src\MessagingDomain\Thread\Action\DeleteThreadAction;
use App\Src\MessagingDomain\Thread\Exception\UserIsNotOwner;
use App\Src\MessagingDomain\Thread\Model\Thread;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class DeleteThreadController extends Controller
{


    public function __invoke(Thread $thread)
    {
        try {

            DB::beginTransaction();

            $action = app(DeleteThreadAction::class);
            $action->handle($thread, user());

            DB::commit();

            flash(trans('messaging.thread.delete.success'))->success();

            return redirect()->route('get.admin.messaging.sent.index');

        } catch (UserIsNotOwner $exception){

            flash(trans('messaging.thread.delete.error.user_is_not_owner'))->error();

            return back();
        }
        catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when delete tread.', [
                'thread' => $thread,
                'exception' => $exception,
            ]);

            flash(trans('messaging.thread.delete.error'))->error();

            return back()->withInput();
        }
    }
}
