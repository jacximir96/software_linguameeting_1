<?php
namespace App\Http\Controllers\Experience;

use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\Experience\Action\CreateTipAction;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\Experience\Request\TipRequest;
use App\Src\ExperienceDomain\Experience\Service\TipForm;
use App\Src\ThirdPartiesDomain\Braintree\Exception\TransactionSaleException;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CreateTipController extends Controller
{

    public function configView(Experience $experience, User $donor)
    {
        $donor = user();

        $form = app(TipForm::class);
        $form->config($experience, $donor);

        view()->share([
            'experience' => $experience,
            'form' => $form,
            'donor' => $donor,
        ]);

        return view('experience.tip_form');
    }

    public function update(TipRequest $request, Experience $experience, User $donor)
    {
        try {

            DB::beginTransaction();;

            $action = app(CreateTipAction::class);
            $action->handle($request, $experience, $donor);

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

            Log::error('When create a payment tip for the experience.', [
                'user' => user(),
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('payment.experience.tip.error.general'))->error();

            return back();
        }
    }
}
