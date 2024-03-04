<?php
namespace App\Http\Controllers\Public\Experience;

use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceComment\Action\CreateAnonymousCommentAction;
use App\Src\ExperienceDomain\ExperienceComment\Request\AnonymousRateExperienceRequest;
use App\Src\ExperienceDomain\ExperienceComment\Service\AnonymousCommentForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class RateExperienceController extends Controller
{

    public function configView(Experience $experience)
    {

        $form = app(AnonymousCommentForm::class);
        $form->config($experience);

        view()->share([
            'experience' => $experience,
            'form' => $form,
        ]);

        return view('web.experiences.form.rate');
    }

    public function comment(AnonymousRateExperienceRequest $request, Experience $experience)
    {
        try {

            DB::beginTransaction();

            $action = app(CreateAnonymousCommentAction::class);
            $action->handle($request, $experience);

            DB::commit();

            flash(trans('experience.comment.public.create_success'))->success();

            return back();

        }
        catch (\Throwable $exception) {

            DB::rollback();

            Log::error('When create a public comment in a experience.', [
                'experience' => $experience,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('experience.comment.public.error.general'))->error();

            return back();
        }
    }
}
