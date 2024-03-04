<?php

namespace App\Http\Controllers\Admin\Config\ConversationGuide\Chapter;

use App\Http\Controllers\Controller;
use App\Src\ConversationGuideDomain\Chapter\Action\UpdateChapterAction;
use App\Src\ConversationGuideDomain\Chapter\Model\Chapter;
use App\Src\ConversationGuideDomain\Chapter\Request\ChapterRequest;
use App\Src\ConversationGuideDomain\Chapter\Service\ChapterForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EditChapterController extends Controller
{
    public function configView(Chapter $chapter)
    {

        $form = app(ChapterForm::class);
        $form->configToEdit($chapter);

        view()->share([
            'chapter' => $chapter,
            'form' => $form,
        ]);

        return view('admin.config.conversation-guide.chapter.form');
    }

    public function update(ChapterRequest $request, Chapter $chapter)
    {
        try {

            DB::beginTransaction();

            $action = app(UpdateChapterAction::class);
            $action->handle($request, $chapter);

            DB::commit();

            flash(trans('config.chapter.update_success'))->success();

            return back()->withInput();
        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when update chapter.', [
                'chapter' => $chapter,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('config.chapter.error.on_update'))->error();

            return back()->withInput();
        }
    }
}
