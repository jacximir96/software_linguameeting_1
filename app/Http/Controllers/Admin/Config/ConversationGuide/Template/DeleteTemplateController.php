<?php

namespace App\Http\Controllers\Admin\Config\ConversationGuide\Template;

use App\Http\Controllers\Controller;
use App\Src\ConversationGuideDomain\Template\Action\DeleteTemplateAction;
use App\Src\ConversationGuideDomain\Template\Model\Template;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteTemplateController extends Controller
{
    public function __invoke(Template $template)
    {
        try {

            DB::beginTransaction();

            $action = app(DeleteTemplateAction::class);
            $action->handle($template);

            DB::commit();

            flash(trans('config.template.delete_success'))->success();

            return back()->withInput();
        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when delete template.', [
                'template' => $template,
                'exception' => $exception,
            ]);

            flash(trans('config.template.error.on_delete'))->error();

            return back()->withInput();
        }
    }
}
