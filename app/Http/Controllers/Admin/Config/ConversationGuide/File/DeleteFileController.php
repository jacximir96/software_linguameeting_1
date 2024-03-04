<?php

namespace App\Http\Controllers\Admin\Config\ConversationGuide\File;

use App\Http\Controllers\Controller;
use App\Src\ConversationGuideDomain\GuideFile\Action\DeleteGuideFileAction;
use App\Src\ConversationGuideDomain\GuideFile\Model\ConversationGuideFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteFileController extends Controller
{
    public function __invoke(ConversationGuideFile $file)
    {
        try {

            DB::beginTransaction();

            $action = app(DeleteGuideFileAction::class);
            $action->handle($file);

            DB::commit();

            flash(trans('config.conversation_guide.file.delete_success'))->success();

            return back();
        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when delete conversation guide file.', [
                'conversationGuideFile' => $file,
                'exception' => $exception,
            ]);

            flash(trans('config.conversation_guide.file.error.on_delete'))->error();

            return back()->withInput();
        }
    }
}
