<?php
namespace App\Src\PaymentDomain\PaymentDetail\Repository;

use App\Src\PaymentDomain\PaymentDetail\Model\PaymentDetail;
use App\Src\Shared\Model\Morpheable;


class PaymentDetailRepository
{

    public function obtainDetail(Morpheable $model)
    {
        return PaymentDetail::query()
            ->with($this->relations())
            ->where('payable_type', $model->morphType())
            ->where('payable_id', $model->id)
            ->orderBy('id', 'desc')
            ->paginate(config('linguameeting.items_per_page_short'));
    }

    public function relations ():array{
        return [
            'payment',
            'payment.methodPayment',
            'payment.payer',
            'payment.publicPayer',
        ];
    }
}
