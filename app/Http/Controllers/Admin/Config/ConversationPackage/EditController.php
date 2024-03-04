<?php
namespace App\Http\Controllers\Admin\Config\ConversationPackage;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\ConversationPackageDomain\Package\Action\UpdateConversationPackageAction;
use App\Src\ConversationPackageDomain\Package\Model\ConversationPackage;
use App\Src\ConversationPackageDomain\Package\Presenter\Breadcrumb\EditBreadcrumb;
use App\Src\ConversationPackageDomain\Package\Request\ConversationPackageRequest;
use App\Src\ConversationPackageDomain\Package\Service\ConversationPackageForm;
use Illuminate\Support\Facades\Log;


class EditController extends Controller
{

    use Breadcrumable;

    public function configView(ConversationPackage $conversationPackage)
    {

        $breadcrumb = new EditBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        $form = app(ConversationPackageForm::class);
        $form->configForEdit($conversationPackage);

        view()->share([
            'conversationPackage' => $conversationPackage,
            'form' => $form,
        ]);

        return view('admin.config.conversation-package.form');
    }

    public function update(ConversationPackageRequest $request, ConversationPackage $conversationPackage)
    {
        try {

            $action = app(UpdateConversationPackageAction::class);
            $action->handle($request, $conversationPackage);

            flash(trans('config.conversation_package.update_success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {


            Log::error('There is an error when update conversation package.', [
                'conversationPackage' => $conversationPackage,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('config.conversation_package.error.on_update'))->error();

            return back()->withInput();
        }
    }
}
