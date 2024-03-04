<?php

namespace App\Http\Controllers\Admin\Course\Session;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\SessionDomain\Session\Action\DeleteSessionAction;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteSessionController extends Controller
{
    public function __invoke(Session $session)
    {

        try {

            DB::beginTransaction();

            $action = app(DeleteSessionAction::class);
            $action->handle($session);

            DB::commit();

            flash(trans('course.session.delete.success'))->success();

            return back();

        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when delete session', [
                'session' => $session,
                'exception' => $exception,
            ]);

            flash(trans('course.session.error.on_delete'))->error();

            return back();
        }
    }
}
