<?php
namespace App\Src\PaymentDomain\Payment\Repository;

use App\Src\PaymentDomain\Payment\Model\Payment;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\UserDomain\User\Model\User;


class PaymentRepository
{

    public function allPaginate (){

        return Payment::query()
            ->with($this->relations())
            ->orderBy('paid_at', 'desc')
            ->paginate(config('linguameeting.items_per_page'));

    }

    public function obtainFromStudent (User $student){

        return Payment::query()
            ->with($this->relations())
            ->where('payer_id', $student->id)
            ->orderBy('paid_at', 'desc')
            ->get();
    }

    public function relations():array{

        return [
            'detail',
            'detail.payable',
            'methodPayment',
            'payer',
            'publicPayer',
            'registerCode',
            'refund',
        ];
    }
}
