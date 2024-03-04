<?php

namespace App\Http\Controllers\Admin\Config\ConversationGuide\Chapter;

use App\Http\Controllers\Controller;
use App\Src\ConversationGuideDomain\Chapter\Action\CreateChapterAction;
use App\Src\ConversationGuideDomain\Chapter\Request\ChapterRequest;
use App\Src\ConversationGuideDomain\Chapter\Service\ChapterForm;
use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateChapterController extends Controller
{
    public function configView(ConversationGuide $guide)
    {

        $form = app(ChapterForm::class);
        $form->configToCreate($guide);

        view()->share([
            'guide' => $guide,
            'form' => $form,
        ]);

        return view('admin.config.conversation-guide.chapter.form');
    }

    public function create(ChapterRequest $request, ConversationGuide $guide)
    {
        try {

            DB::beginTransaction();

            $action = app(CreateChapterAction::class);
            $action->handle($request, $guide);

            DB::commit();

            flash(trans('config.chapter.create_success'))->success();

            return back();
        } catch (\Throwable $exception) {

            Log::error('There is an error when create conversation guide.', [
                'guide' => $guide,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('config.chapter.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
