<?php

namespace App\Http\Controllers\Api\Coach\Billing\Payment;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Payment\Action\ChangePaidAction;
use App\Src\CoachDomain\Payment\Model\Payment;
use Illuminate\Support\Facades\Log;


class ChangePaidController extends Controller
{
    public function __invoke(Payment $payment)
    {
        try {

            $action = app(ChangePaidAction::class);
            $action->handle($payment);

            return response('Payment change paid successfully', 200);

        } catch (\Throwable $exception) {

            Log::error('There is an error when changing is paid from payment', [
                'payment' => $payment,
                'exception' => $exception,
            ]);

            return response('Error while changing is paid ', 500);
        }
    }
}
