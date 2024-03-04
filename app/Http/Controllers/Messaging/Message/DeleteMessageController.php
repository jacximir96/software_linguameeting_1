<?php

namespace App\Http\Controllers\Messaging\Message;

use App\Http\Controllers\Controller;
use App\Src\MessagingDomain\Message\Action\DeleteMessageAction;
use App\Src\MessagingDomain\Message\Exception\MessageIsNotLastest;
use App\Src\MessagingDomain\Message\Exception\UserIsNotOwner;
use App\Src\MessagingDomain\Message\Model\Message;
use Illuminate\Support\Facades\Log;


class DeleteMessageController extends Controller
{

    public function __invoke(Message $message)
    {
        try {

            $action = app(DeleteMessageAction::class);
            $action->handle($message, user());

            flash(trans('messaging.message.delete.success'))->success();

            return back();
        }
        catch (UserIsNotOwner $exception){
            flash(trans('messaging.message.delete.error.user_is_not_owner'))->error();

            return back();
        }
        catch (MessageIsNotLastest $exception){
            flash(trans('messaging.message.delete.error.message_is_not_latest'))->error();

            return back();
        }
        catch (\Throwable $exception) {

            Log::error('There is an error when delete a message.', [
                'message' => $message,
                'exception' => $exception,
            ]);

            flash(trans('messaging.message.delete.error.on_delete'))->error();

            return back()->withInput();
        }
    }
}
