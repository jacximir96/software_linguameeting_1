<?php

namespace App\Http\Controllers\Admin\Config\ExperienceLevel;

use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\Level\Action\CreateExperienceLevelAction;
use App\Src\ExperienceDomain\Level\Request\ExperienceLevelRequest;
use App\Src\ExperienceDomain\Level\Service\ExperienceLevelForm;
use Illuminate\Support\Facades\Log;


class CreateController extends Controller
{

    public function configView( )
    {

        $form = app(ExperienceLevelForm::class);
        $form->configForCreate();

        view()->share([
            'form' => $form,
        ]);

        return view('admin.config.accommodation-type.form');
    }


    public function create(ExperienceLevelRequest $request)
    {
        try {

            $action = app(CreateExperienceLevelAction::class);
            $accommodationType = $action->handle($request);

            flash(trans('config.experience_level.create_success'))->success();

            return redirect()->route('get.admin.config.experience_level.create');

        } catch (\Throwable $exception) {



            Log::error('There is an error when create accommodation type.', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('config.accommodation_type.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
