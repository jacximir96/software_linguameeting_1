<?php
namespace App\Src\PaymentDomain\Payment\Action\Command;

use App\Src\PaymentDomain\MethodPayment\Model\MethodPayment;
use App\Src\PaymentDomain\Payment\Model\Payment;
use App\Src\PaymentDomain\Payment\Service\FreePaymentDto;


class PayFreeCommand
{
    private PaymentBuilder $paymentBuilder;

    private Payment $payment;

    public function __construct(PaymentBuilder $paymentBuilder)
    {
        $this->paymentBuilder = $paymentBuilder;
    }

    public function handle(FreePaymentDto $paymentDto): Payment
    {
        $this->createPayment($paymentDto);

        $this->paymentBuilder->createDetail($paymentDto->getDetailCollection(), $this->payment);

        return $this->payment;
    }

    private function createPayment(FreePaymentDto $paymentDto)
    {
        $this->payment = $this->paymentBuilder->buildPayment($paymentDto->getUser(), $paymentDto->getAmount());

        $this->payment->method_payment_id = MethodPayment::ID_FREE;
        $this->payment->transaction_id = MethodPayment::FREE;

        $this->payment->save();
    }
}
