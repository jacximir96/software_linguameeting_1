<?php
namespace App\Http\Controllers\Admin\Survey;

use App\Http\Controllers\Controller;
use App\Src\Survey\Action\DeleteSurveyAction;
use App\Src\Survey\Model\Survey;
use Illuminate\Support\Facades\Log;


class DeleteSurveyController extends Controller
{

    public function __invoke(Survey $survey)
    {
        try {

            $action = app(DeleteSurveyAction::class);
            $action->handle($survey);

            flash(trans('survey.delete_success'))->success();

            return back();

        } catch (\Throwable $exception) {

            Log::error('There is an error when delete survey.', [
                'survey' => $survey,
                'exception' => $exception,
            ]);

            flash(trans('survey.error.on_delete'))->error();

            return back()->withInput();
        }
    }
}
