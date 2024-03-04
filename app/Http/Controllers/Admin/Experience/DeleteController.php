<?php

namespace App\Http\Controllers\Admin\Experience;


use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\Experience\Action\DeleteExperienceAction;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class DeleteController extends Controller
{


    public function __invoke(Experience $experience)
    {
        try {

            DB::beginTransaction();

            $action = app(DeleteExperienceAction::class);
            $action->handle($experience);

            DB::commit();

            flash(trans('experience.delete_success'))->success();

            return redirect()->route('get.admin.experience.index');

        } catch (\Throwable $exception) {

            Log::error('There is an error when delete experience', [
                'experience' => $experience,
                'exception' => $exception,
            ]);

            flash(trans('experience.error.on_delete'))->error();

            return back();
        }
    }
}
