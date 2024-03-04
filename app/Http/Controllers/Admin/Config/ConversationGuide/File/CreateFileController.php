<?php

namespace App\Http\Controllers\Admin\Config\ConversationGuide\File;

use App\Http\Controllers\Controller;
use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\ConversationGuideDomain\GuideFile\Action\CreateGuideFileAction;
use App\Src\ConversationGuideDomain\GuideFile\Request\GuideFileRequest;
use App\Src\ConversationGuideDomain\GuideFile\Service\GuideFileForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateFileController extends Controller
{
    public function configView(ConversationGuide $guide)
    {

        $form = app(GuideFileForm::class);
        $form->configToCreate($guide);

        view()->share([
            'guide' => $guide,
            'form' => $form,
        ]);

        return view('admin.config.conversation-guide.file.form');
    }

    public function create(GuideFileRequest $request, ConversationGuide $guide)
    {
        try {

            DB::beginTransaction();

            $action = app(CreateGuideFileAction::class);
            $action->handle($request, $guide);

            DB::commit();

            flash(trans('config.conversation_guide.file.create_success'))->success();

            return back();
        } catch (\Throwable $exception) {

            Log::error('There is an error when create conversation guide file.', [
                'guide' => $guide,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('config.conversation_guide.file.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
