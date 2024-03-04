<?php
namespace App\Http\Controllers\Admin\Config\ConversationPackage;


use App\Http\Controllers\Controller;
use App\Src\ConversationPackageDomain\Package\Action\DeleteConversationPackageAction;
use App\Src\ConversationPackageDomain\Package\Model\ConversationPackage;
use Illuminate\Support\Facades\Log;


class DeleteController extends Controller
{

    public function __invoke(ConversationPackage $conversationPackage)
    {
        try {

            $action = app(DeleteConversationPackageAction::class);
            $action->handle($conversationPackage);

            flash(trans('config.conversation_package.delete_success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when delete conversation package.', [
                'conversationPackage' => $conversationPackage,
                'exception' => $exception,
            ]);

            flash(trans('config.conversation_package.error.on_delete'))->error();

            return back()->withInput();
        }
    }
}
