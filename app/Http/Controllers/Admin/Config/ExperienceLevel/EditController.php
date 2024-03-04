<?php

namespace App\Http\Controllers\Admin\Config\ExperienceLevel;

use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\Level\Action\UpdateExperienceLevelAction;
use App\Src\ExperienceDomain\Level\Model\Level;
use App\Src\ExperienceDomain\Level\Request\ExperienceLevelRequest;
use App\Src\ExperienceDomain\Level\Service\ExperienceLevelForm;
use Illuminate\Support\Facades\Log;


class EditController extends Controller
{

    public function configView(Level $level)
    {

        $form = app(ExperienceLevelForm::class);
        $form->configForEdit($level);

        view()->share([
            'accommodationType' => $level,
            'form' => $form,
        ]);

        return view('admin.config.accommodation-type.form');
    }

    public function update(ExperienceLevelRequest $request, Level $level)
    {
        try {

            $action = app(UpdateExperienceLevelAction::class);
            $action->handle($request, $level);

            flash(trans('config.accommodation_type.update_success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when update experience level.', [
                'level' => $level,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('config.experience_level.error.on_update'))->error();

            return back()->withInput();
        }
    }
}
