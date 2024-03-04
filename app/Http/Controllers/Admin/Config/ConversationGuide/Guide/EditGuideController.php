<?php

namespace App\Http\Controllers\Admin\Config\ConversationGuide\Guide;

use App\Http\Controllers\Controller;
use App\Src\ConversationGuideDomain\Guide\Action\UpdateConversationGuideAction;
use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\ConversationGuideDomain\Guide\Request\ConversationGuideRequest;
use App\Src\ConversationGuideDomain\Guide\Service\ConversationGuideForm;
use Illuminate\Support\Facades\Log;

class EditGuideController extends Controller
{
    public function configView(ConversationGuide $guide)
    {

        $form = app(ConversationGuideForm::class);
        $form->config($guide);

        view()->share([
            'guide' => $guide,
            'form' => $form,
        ]);

        return view('admin.config.conversation-guide.form');
    }

    public function update(ConversationGuideRequest $request, ConversationGuide $guide)
    {
        try {

            $action = app(UpdateConversationGuideAction::class);
            $action->handle($request, $guide);

            flash(trans('config.conversation_guide.update_success'))->success();

            return back()->withInput();
        } catch (\Throwable $exception) {

            Log::error('There is an error when update conversation guide.', [
                'guide' => $guide,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('config.conversation_guide.error.on_update'))->error();

            return back()->withInput();
        }
    }
}
