<?php

namespace App\Http\Controllers\Admin\Config\ConversationGuide\Template;

use App\Http\Controllers\Controller;
use App\Src\ConversationGuideDomain\Template\Action\CreateTemplateAction;
use App\Src\ConversationGuideDomain\Template\Request\TemplateRequest;
use App\Src\ConversationGuideDomain\Template\Service\TemplateForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateTemplateController extends Controller
{
    public function configView()
    {

        $form = app(TemplateForm::class);
        $form->configToCreate();

        view()->share([
            'form' => $form,
        ]);

        return view('admin.config.conversation-guide.template.form');
    }

    public function create(TemplateRequest $request)
    {
        try {

            DB::beginTransaction();

            $action = app(CreateTemplateAction::class);
            $action->handle($request);

            DB::commit();

            flash(trans('config.template.create_success'))->success();

            return back();
        } catch (\Throwable $exception) {

            Log::error('There is an error when create conversation guide.', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('config.template.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
