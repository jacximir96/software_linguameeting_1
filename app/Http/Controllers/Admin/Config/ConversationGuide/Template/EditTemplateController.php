<?php

namespace App\Http\Controllers\Admin\Config\ConversationGuide\Template;

use App\Http\Controllers\Controller;
use App\Src\ConversationGuideDomain\Template\Action\UpdateTemplateAction;
use App\Src\ConversationGuideDomain\Template\Model\Template;
use App\Src\ConversationGuideDomain\Template\Request\TemplateRequest;
use App\Src\ConversationGuideDomain\Template\Service\TemplateForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EditTemplateController extends Controller
{
    public function configView(Template $template)
    {

        $form = app(TemplateForm::class);
        $form->configToEdit($template);

        view()->share([
            'template' => $template,
            'form' => $form,
        ]);

        return view('admin.config.conversation-guide.template.form');
    }

    public function update(TemplateRequest $request, Template $template)
    {
        try {

            DB::beginTransaction();

            $action = app(UpdateTemplateAction::class);
            $action->handle($request, $template);

            DB::commit();

            flash(trans('config.template.update_success'))->success();

            return back()->withInput();
        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when update template.', [
                'template' => $template,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('config.template.error.on_update'))->error();

            return back()->withInput();
        }
    }
}
