<?php

namespace App\Http\Controllers\Admin\University;

use App\Http\Controllers\Controller;
use App\Src\UniversityDomain\University\Action\DeleteUniversityAction;
use App\Src\UniversityDomain\University\Model\University;
use Illuminate\Support\Facades\Log;

class DeleteController extends Controller
{
    public function __invoke(University $university)
    {
        try {

            $action = app(DeleteUniversityAction::class);
            $action->handle($university);

            flash(trans('university.delete_success'))->success();

            return back();
        } catch (\Throwable $exception) {
            Log::error('There is an error when delete university', [
                'university' => $university,
                'exception' => $exception,
            ]);

            flash(trans('university.error.on_delete'))->error();

            return back();
        }
    }
}
