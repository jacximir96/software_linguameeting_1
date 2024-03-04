<?php
namespace App\Http\Controllers\Admin\Survey;

use App\Http\Controllers\Controller;
use App\Src\Survey\Action\UpdateSurveyAction;
use App\Src\Survey\Model\Survey;
use App\Src\Survey\Request\SurveyRequest;
use App\Src\Survey\Service\SurveyForm;
use Illuminate\Support\Facades\Log;


class EditSurveyController extends Controller
{
    public function configView(Survey $survey)
    {

        $form = app(SurveyForm::class);
        $form->configToEdit($survey);

        view()->share([
            'form' => $form,
            'survey' => $survey
        ]);

        return view('admin.survey.form');
    }

    public function update(SurveyRequest $request, Survey $survey)
    {
        try {

            $action = app(UpdateSurveyAction::class);
            $action->handle($request, $survey);

            flash(trans('survey.update_success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when update survey.', [
                'survey' => $survey,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('survey.error.on_update'))->error();

            return back()->withInput();
        }
    }
}
