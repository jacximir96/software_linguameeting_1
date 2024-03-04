<?php
namespace App\Http\Controllers\Public\Experience;

use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\Experience\Action\CreatePublicTipAction;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\Experience\Request\PublicTipRequest;
use App\Src\ExperienceDomain\Experience\Service\PublicTipForm;
use App\Src\ThirdPartiesDomain\Braintree\Exception\TransactionSaleException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CreateTipController extends Controller
{
    public function configView(Experience $experience)
    {
        $student = user();

        $form = app(PublicTipForm::class);
        $form->config($experience);

        view()->share([
            'experience' => $experience,
            'form' => $form,
            'student' => $student,
        ]);

        return view('web.experiences.form.tip');
    }

    public function create(PublicTipRequest $request, Experience $experience)
    {
        try {

            DB::beginTransaction();

            $action = app(CreatePublicTipAction::class);
            $action->handle($request, $experience);

            DB::commit();

            flash(trans('payment.experience.tip.success'))->success();

            return view('common.feedback_modal');

        }
        catch (TransactionSaleException $exception){

            DB::rollback();

            flash(trans('payment.transaction.error'))->error();

            return back()->withInput();
        }

        catch (\Throwable $exception) {

            DB::rollback();

            Log::error('When create a tip payment for the experience.', [
                'user' => user(),
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('payment.experience.tip.error.general'))->error();

            return back();
        }
    }
}
