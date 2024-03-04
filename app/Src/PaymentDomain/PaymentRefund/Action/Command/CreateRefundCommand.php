<?php

namespace App\Src\PaymentDomain\PaymentRefund\Action\Command;

use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\NotificationDomain\Notification\Action\Command\SupportNotificationCreator;
use App\Src\PaymentDomain\Payment\Exception\PaymentHasBeenRefunded;
use App\Src\PaymentDomain\Payment\Model\Payment;
use App\Src\PaymentDomain\PaymentRefund\Model\PaymentRefund;
use App\Src\StudentDomain\Enrollment\Exception\RefundFail;
use App\Src\ThirdPartiesDomain\Braintree\Service\Braintree;
use App\Src\ThirdPartiesDomain\Braintree\Service\TransactionId;
use App\Src\ThirdPartiesDomain\Braintree\Service\TransactionRefundDto;
use App\Src\ThirdPartiesDomain\Braintree\Service\TransactionResponse;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CreateRefundCommand
{
    //construct
    private Braintree $braintree;

    private SupportNotificationCreator $notificationCreator;

    //status
    private Payment $payment;

    private User $user;

    private TransactionResponse $transactionResponse;

    public function __construct(Braintree $braintree, SupportNotificationCreator $notificationCreator)
    {

        $this->braintree = $braintree;
        $this->notificationCreator = $notificationCreator;
    }

    public function handle(Payment $payment, User $user): PaymentRefund
    {

        try {

            $this->initialize($payment, $user);

            $this->throwRefund();

            return $this->saveRefund();
        } catch (\Throwable $exception) {

            $this->notificationCreator->createRefundErrorNotification($payment, $this->transactionResponse, $exception);
            throw $exception;
        }
    }

    private function initialize(Payment $payment, User $user)
    {

        $this->payment = $payment;
        $this->user = $user;

        $this->transactionResponse = new TransactionResponse([]);
    }

    private function throwRefund()
    {

        $transactionId = new TransactionId($this->payment->transaction_id);
        $refundDto = new TransactionRefundDto($transactionId);
        $this->transactionResponse = $this->braintree->transactioRefund($refundDto);

        if (! $this->transactionResponse->transactionIsSuccess()) {

            Log::channel('credit_card')->error('Error refund', [
                'user' => $this->user->writeFullName(),
                'payment_id' => $this->payment->payment_id,
                'errors' => $this->transactionResponse->errorsToJson(),
            ]);

            if ($this->transactionResponse->transactionHasBeenRefunded()) {
                throw new PaymentHasBeenRefunded();
            }

            throw new RefundFail();
        }
    }

    private function saveRefund(): PaymentRefund
    {

        $refund = new PaymentRefund();
        $refund->payment_id = $this->payment->id;

        $refund->value = $this->transactionResponse->amount();
        $refund->transaction_id = $this->transactionResponse->transactionId();
        $refund->refund_at = Carbon::now();

        $refund->save();

        return $refund;

    }
}
