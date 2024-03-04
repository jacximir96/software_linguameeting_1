<?php
namespace App\Src\PaymentDomain\Payment\Action\Command;

use App\Src\PaymentDomain\MethodPayment\Model\MethodPayment;
use App\Src\PaymentDomain\Payment\Model\Payment;
use App\Src\PaymentDomain\Payment\Service\CreditCardPaymentDto;
use App\Src\PaymentDomain\PaymentDetail\Model\PaymentDetail;


class PayWithCreditCardCommand
{
    private PaymentBuilder $paymentBuilder;

    private Payment $payment;

    public function __construct(PaymentBuilder $paymentBuilder)
    {
        $this->paymentBuilder = $paymentBuilder;
    }

    public function handle(CreditCardPaymentDto $paymentDto): Payment
    {
        $this->createPayment($paymentDto);

        $this->createDetail($paymentDto);

        return $this->payment;
    }


    private function createPayment(CreditCardPaymentDto $paymentDto)
    {
        $this->payment = $this->paymentBuilder->buildPayment($paymentDto->getUser(), $paymentDto->getAmount());

        $this->payment->method_payment_id = MethodPayment::ID_CREDIT_CARD;
        $this->payment->transaction_id = $paymentDto->getTransactionResponse()->transactionId();

        $this->payment->save();
    }

    private function createDetail (CreditCardPaymentDto $paymentDto){

        foreach ($paymentDto->getDetailCollection()->get() as $item){

            $detail = new PaymentDetail();
            $detail->payable_type = $item->morphType();
            $detail->payable_id = $item->id;
            $detail->payment_id = $this->payment->id;

            $detail->save();
        }
    }
}
