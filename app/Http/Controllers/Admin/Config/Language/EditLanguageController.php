<?php

namespace App\Http\Controllers\Admin\Config\Language;

use App\Http\Controllers\Controller;
use App\Src\Localization\Language\Action\UpdateLanguageAction;
use App\Src\Localization\Language\Model\Language;
use App\Src\Localization\Language\Request\LanguageRequest;
use App\Src\Localization\Language\Service\LanguageForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EditLanguageController extends Controller
{
    public function configView(Language $language)
    {

        $form = app(LanguageForm::class);
        $form->configToEdit($language);

        view()->share([
            'language' => $language,
            'form' => $form,
        ]);

        return view('admin.config.language.form');
    }

    public function update(LanguageRequest $request, Language $language)
    {
        try {

            DB::beginTransaction();

            $action = app(UpdateLanguageAction::class);
            $action->handle($request, $language);

            DB::commit();

            flash(trans('config.language.update_success'))->success();

            return back()->withInput();
        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when update language.', [
                'language' => $language,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('config.language.error.on_update'))->error();

            return back()->withInput();
        }
    }
}
