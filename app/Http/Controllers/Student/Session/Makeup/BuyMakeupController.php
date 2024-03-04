<?php
namespace App\Http\Controllers\Student\Session\Makeup;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Repository\EnrollmentSessionRepository;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Makeup\Action\BuyMakeupAction;
use App\Src\StudentDomain\Makeup\Request\BuyMakeupRequest;
use App\Src\StudentDomain\Makeup\Service\BuyMakeupForm;
use App\Src\StudentDomain\Makeup\Service\MakeupSearcher;
use App\Src\ThirdPartiesDomain\Braintree\Exception\TransactionSaleException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class BuyMakeupController extends Controller
{

    private LinguaMoney $linguaMoney;

    private EnrollmentSessionRepository $enrollmentSessionRepository;

    public function __construct (LinguaMoney $linguaMoney, EnrollmentSessionRepository $enrollmentSessionRepository){
        $this->linguaMoney = $linguaMoney;
        $this->enrollmentSessionRepository = $enrollmentSessionRepository;
    }

    public function configView(Enrollment $enrollment)
    {

        $makeupSearcher = app(MakeupSearcher::class);
        $makeupAvailability = $makeupSearcher->searchFromEnrollment($enrollment);

        $form = app(BuyMakeupForm::class);
        $form->config($enrollment);

        $costByOneMakeup = $enrollment->course()->priceBuyOneMakeup();

        view()->share([
            'costByOneMakeup' => $costByOneMakeup,
            'enrollment' => $enrollment,
            'form' => $form,
            'makeupAvailability' => $makeupAvailability,
        ]);

        return view('student.enrollment.session.makeup.buy.index');
    }

    public function buy(BuyMakeupRequest $request, Enrollment $enrollment)
    {
        try {

            DB::beginTransaction();;

            $action = app(BuyMakeupAction::class);
            $action->handle($request, $enrollment, user());

            DB::commit();

            if ($request->number_makeups == 1){
                flash(trans('payment.makeup.success_one'))->success();
            }
            else{
                flash(trans('payment.makeup.success_several', ['number' => $request->number_makeups]))->success();
            }

            return view('common.feedback_modal');

        }
        catch (TransactionSaleException $exception){

            DB::rollback();

            flash(trans('payment.transaction.error'))->error();

            return back()->withInput();
        }

        catch (\Throwable $exception) {

            DB::rollback();

            Log::error('When create a payment for the makeup.', [
                'user' => user(),
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('payment.makeup.error.general'))->error();

            return back();
        }
    }
}
