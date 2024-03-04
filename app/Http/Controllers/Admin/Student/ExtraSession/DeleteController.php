<?php
namespace App\Http\Controllers\Admin\Student\ExtraSession;

use App\Http\Controllers\Controller;
use App\Src\StudentDomain\ExtraSession\Action\DeleteExtraSessionAction;
use App\Src\StudentDomain\ExtraSession\Exception\ExtraSessionHasBeenUsed;
use App\Src\StudentDomain\ExtraSession\Model\ExtraSession;
use Illuminate\Support\Facades\Log;


class DeleteController extends Controller
{

    public function __invoke(ExtraSession $extraSession)
    {
        try {

            $action = app(DeleteExtraSessionAction::class);
            $action->handle($extraSession);

            flash(trans('student.enrollment.extra_session.delete_success'))->success();

            return back();

        }
        catch (ExtraSessionHasBeenUsed $exception){

            flash(trans('student.enrollment.extra_session.error.not_deleted_has_been_used'))->error();

            return back();

        }
        catch (\Throwable $exception) {

            Log::error('There is an error when delete extra session', [
                'extra_session' => $extraSession,
                'exception' => $exception,
            ]);

            flash(trans('student.enrollment.extra_session.error.on_delete'))->error();

            return back();
        }
    }
}
