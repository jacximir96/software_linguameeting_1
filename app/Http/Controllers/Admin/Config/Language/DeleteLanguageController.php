<?php

namespace App\Http\Controllers\Admin\Config\Language;

use App\Http\Controllers\Controller;
use App\Src\Localization\Language\Action\DeleteLanguageAction;
use App\Src\Localization\Language\Model\Language;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteLanguageController extends Controller
{


    public function __invoke( Language $language)
    {
        try {

            DB::beginTransaction();

            $action = app(DeleteLanguageAction::class);
            $action->handle($language);

            DB::commit();

            flash(trans('config.language.delete_success'))->success();

            return back();

        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when delete language.', [
                'language' => $language,
                'exception' => $exception,
            ]);

            flash(trans('config.language.error.on_delete'))->error();

            return back()->withInput();
        }
    }
}
