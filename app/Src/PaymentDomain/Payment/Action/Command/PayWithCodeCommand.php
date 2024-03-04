<?php

namespace App\Src\PaymentDomain\Payment\Action\Command;

use App\Src\PaymentDomain\MethodPayment\Model\MethodPayment;
use App\Src\PaymentDomain\Payment\Model\Payment;
use App\Src\PaymentDomain\Payment\Service\CodePaymentDto;
use App\Src\PaymentDomain\PaymentDetail\Model\PaymentDetail;
use App\Src\RegisterCodeDomain\RegisterCode\Model\RegisterCode;

class PayWithCodeCommand
{
    private PaymentBuilder $paymentBuilder;

    private Payment $payment;

    public function __construct(PaymentBuilder $paymentBuilder)
    {

        $this->paymentBuilder = $paymentBuilder;
    }

    public function handle(CodePaymentDto $paymentDto): Payment
    {

        $this->markRegisterCodeAsSaved($paymentDto->getRegisterCode());

        $this->createPayment($paymentDto);

        $this->createDetail($paymentDto);

        return $this->payment;
    }

    private function markRegisterCodeAsSaved(RegisterCode $registerCode): RegisterCode
    {
        $registerCode->is_used = true;
        $registerCode->save();

        return $registerCode;
    }

    private function createPayment(CodePaymentDto $paymentDto)
    {

        $this->payment = $this->paymentBuilder->buildPayment($paymentDto->getUser(), $paymentDto->getAmount());

        $this->payment->method_payment_id = MethodPayment::ID_CODE;
        $this->payment->transaction_id = $paymentDto->getRegisterCode()->code;
        $this->payment->register_code_id = $paymentDto->getRegisterCode()->id;

        $this->payment->save();
    }

    private function createDetail (CodePaymentDto $paymentDto){

        foreach ($paymentDto->getDetailCollection()->get() as $item){

            $detail = new PaymentDetail();
            $detail->payable_type = $item->morphType();
            $detail->payable_id = $item->id;
            $detail->payment_id = $this->payment->id;

            $detail->save();
        }
    }
}
