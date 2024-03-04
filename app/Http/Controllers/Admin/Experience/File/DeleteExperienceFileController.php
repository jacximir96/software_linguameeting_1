<?php

namespace App\Http\Controllers\Admin\Experience\File;


use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\ExperienceFile\Action\DeleteExperienceFileAction;
use App\Src\ExperienceDomain\ExperienceFile\Model\ExperienceFile;
use Illuminate\Support\Facades\DB;


class DeleteExperienceFileController extends Controller
{


    public function __invoke(ExperienceFile $experienceFile)
    {
        try {

            DB::beginTransaction();

            $action = app(DeleteExperienceFileAction::class);
            $action->handle($experienceFile);

            DB::commit();

            flash(trans('linguameeting_common.file.delete.success'))->success();

            return back();

        } catch (\Throwable $exception) {

            DB::rollback();

            flash(trans('linguameeting_common.file.delete.error.on_delete'))->error();

            return back();
        }
    }
}
