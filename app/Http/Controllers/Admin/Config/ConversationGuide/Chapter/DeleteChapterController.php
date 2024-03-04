<?php

namespace App\Http\Controllers\Admin\Config\ConversationGuide\Chapter;

use App\Http\Controllers\Controller;
use App\Src\ConversationGuideDomain\Chapter\Action\DeleteChapterAction;
use App\Src\ConversationGuideDomain\Chapter\Model\Chapter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteChapterController extends Controller
{
    public function __invoke(Chapter $chapter)
    {
        try {

            DB::beginTransaction();

            $action = app(DeleteChapterAction::class);
            $action->handle($chapter);

            DB::commit();

            flash(trans('config.chapter.delete_success'))->success();

            return back()->withInput();
        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when delete chapter.', [
                'chapter' => $chapter,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('config.chapter.error.on_delete'))->error();

            return back()->withInput();
        }
    }
}
