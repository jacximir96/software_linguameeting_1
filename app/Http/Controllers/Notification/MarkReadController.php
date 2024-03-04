<?php
namespace App\Http\Controllers\Notification;


use App\Http\Controllers\Controller;
use App\Src\NotificationDomain\NotificationRecipient\Action\MarkNotificationReadAction;
use App\Src\NotificationDomain\NotificationRecipient\Model\NotificationRecipient;


class MarkReadController extends Controller
{


    public function __invoke(NotificationRecipient $notificationRecipient)
    {

        try{

            $action = app(MarkNotificationReadAction::class);
            $action->handle($notificationRecipient);

            flash('Notification updated succesfully.')->success();

            return back()->withInput();

        }
        catch (\Throwable $exception){

        }
    }
}
