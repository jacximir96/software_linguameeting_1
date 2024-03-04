<?php

namespace App\Http\Controllers\Admin\Messaging\Thread;

use App\Http\Controllers\Controller;
use App\Src\MessagingDomain\Thread\Action\CreateThreadAction;
use App\Src\MessagingDomain\Thread\Request\ThreadRequest;
use App\Src\MessagingDomain\Thread\Service\ThreadForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CreateThreadController extends Controller
{

    public function configView()
    {
        $form = app(ThreadForm::class);
        $form->configForCreate();

        view()->share([
            'form' => $form,
        ]);

        return view('admin.messaging.form');
    }

    public function create(ThreadRequest $request)
    {
        try {

            DB::beginTransaction();

            $action = app(CreateThreadAction::class);
            $action->handle($request, user());

            DB::commit();

            flash(trans('messaging.thread.create.success'))->success();

            return view('common.feedback_modal');

        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when create message.', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('messaging.thread.create.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
