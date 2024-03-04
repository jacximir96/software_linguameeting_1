<?php
namespace App\Http\Controllers\Admin\Survey;

use App\Http\Controllers\Controller;
use App\Src\Survey\Action\CreateSurveyAction;
use App\Src\Survey\Request\SurveyRequest;
use App\Src\Survey\Service\SurveyForm;
use Illuminate\Support\Facades\Log;


class CreateSurveyController extends Controller
{
    public function configView(string $type, int $id)
    {

        $form = app(SurveyForm::class);
        $form->configToCreate($type, $id);

        view()->share([
            'form' => $form,
        ]);

        return view('admin.survey.form');
    }

    public function create(SurveyRequest $request, string $type, int $id)
    {
        try {

            $action = app(CreateSurveyAction::class);
            $survey  =$action->handle($request, $type, $id);

            flash(trans('survey.create_success'))->success();

            return redirect()->route('get.admin.survey.edit', $survey->hashId());

        } catch (\Throwable $exception) {

            Log::error('There is an error when create survey.', [
                'type' => $type,
                'id' => $id,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('survey.error.on_create'))->error();

            return back()->withInput();
        }
    }
}
