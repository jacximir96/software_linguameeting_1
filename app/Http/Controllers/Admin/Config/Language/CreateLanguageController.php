<?php

namespace App\Http\Controllers\Admin\Config\Language;

use App\Http\Controllers\Controller;
use App\Src\Localization\Language\Action\CreateLanguageAction;
use App\Src\Localization\Language\Request\LanguageRequest;
use App\Src\Localization\Language\Service\LanguageForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateLanguageController extends Controller
{
    public function configView()
    {

        $form = app(LanguageForm::class);
        $form->configToCreate();

        view()->share([
            'form' => $form,
        ]);

        return view('admin.config.language.form');
    }

    public function create(LanguageRequest $request)
    {
        try {

            DB::beginTransaction();

            $action = app(CreateLanguageAction::class);
            $action->handle($request);

            DB::commit();

            flash(trans('config.language.create_success'))->success();

            return redirect()->route('get.admin.config.language.create');
        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when create language.', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('config.language.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
