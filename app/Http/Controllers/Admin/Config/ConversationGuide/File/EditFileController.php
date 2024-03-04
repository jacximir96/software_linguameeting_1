<?php

namespace App\Http\Controllers\Admin\Config\ConversationGuide\File;

use App\Http\Controllers\Controller;
use App\Src\ConversationGuideDomain\GuideFile\Action\UpdateGuideFileAction;
use App\Src\ConversationGuideDomain\GuideFile\Model\ConversationGuideFile;
use App\Src\ConversationGuideDomain\GuideFile\Request\UpdateGuideFileRequest;
use App\Src\ConversationGuideDomain\GuideFile\Service\GuideFileForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EditFileController extends Controller
{
    public function configView(ConversationGuideFile $file)
    {

        $form = app(GuideFileForm::class);
        $form->configToEdit($file);

        view()->share([
            'file' => $file,
            'form' => $form,
        ]);

        return view('admin.config.conversation-guide.file.form');
    }

    public function update(UpdateGuideFileRequest $request, ConversationGuideFile $file)
    {
        try {

            DB::beginTransaction();

            $action = app(UpdateGuideFileAction::class);
            $action->handle($request, $file);

            DB::commit();

            flash(trans('config.conversation_guide.file.update_success'))->success();

            return back()->withInput();
        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when update chapter.', [
                'file' => $file,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('config.chapter.error.on_update'))->error();

            return back()->withInput();
        }
    }
}
