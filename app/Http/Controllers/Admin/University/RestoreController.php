<?php

namespace App\Http\Controllers\Admin\University;

use App\Http\Controllers\Controller;
use App\Src\UniversityDomain\University\Action\RestoreUniversityAction;
use App\Src\UniversityDomain\University\Model\University;
use Illuminate\Support\Facades\Log;

class RestoreController extends Controller
{
    public function __invoke(int $id)
    {
        try {

            $university = University::withTrashed()->find($id);

            $action = app(RestoreUniversityAction::class);
            $action->handle($university);

            flash(trans('university.restore_success'))->success();

            return back();
        } catch (\Throwable $exception) {

            Log::error('There is an error when restore university', [
                'universityId' => $id,
                'exception' => $exception,
            ]);

            flash(trans('university.error.on_restore'))->error();

            return back();
        }
    }
}
