<?php
namespace App\Http\Controllers\Admin\Student\Makeup;

use App\Http\Controllers\Controller;
use App\Src\StudentDomain\Makeup\Action\DeleteMakeupAction;
use App\Src\StudentDomain\Makeup\Exception\MakeupHasBeenUsed;
use App\Src\StudentDomain\Makeup\Model\Makeup;
use Illuminate\Support\Facades\Log;


class DeleteController extends Controller
{


    public function __invoke(Makeup $makeup)
    {
        try {

            $action = app(DeleteMakeupAction::class);
            $action->handle($makeup);

            flash(trans('student.enrollment.makeup.delete_success'))->success();

            return back();

        }
        catch (MakeupHasBeenUsed $exception){

            flash(trans('student.enrollment.makeup.error.not_deleted_has_been_used'))->error();

            return back();

        }
        catch (\Throwable $exception) {

            Log::error('There is an error when delete makeup', [
                'makeup' => $makeup,
                'exception' => $exception,
            ]);

            flash(trans('student.enrollment.makeup.error.on_delete'))->error();

            return back();
        }
    }
}
