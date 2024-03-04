<?php
namespace App\Http\Controllers\Admin\Config\ConversationPackage;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\ConversationPackageDomain\Package\Action\CreateConversationPackageAction;
use App\Src\ConversationPackageDomain\Package\Action\UpdateConversationPackageAction;
use App\Src\ConversationPackageDomain\Package\Model\ConversationPackage;
use App\Src\ConversationPackageDomain\Package\Presenter\Breadcrumb\CreateBreadcrumb;
use App\Src\ConversationPackageDomain\Package\Request\ConversationPackageRequest;
use App\Src\ConversationPackageDomain\Package\Service\ConversationPackageForm;
use Illuminate\Support\Facades\Log;


class CreateController extends Controller
{

    use Breadcrumable;

    public function configView()
    {

        $breadcrumb = new CreateBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        $form = app(ConversationPackageForm::class);
        $form->configForCreate();

        view()->share(['form' => $form]);

        return view('admin.config.conversation-package.form');
    }

    public function create(ConversationPackageRequest $request)
    {
        try {

            $action = app(CreateConversationPackageAction::class);
            $action->handle($request);

            flash(trans('config.conversation_package.update_success'))->success();

            return redirect()->route('get.admin.config.conversation_package.index');

        } catch (\Throwable $exception) {

            Log::error('There is an error when create conversation package.', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('config.conversation_package.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
