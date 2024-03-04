<?php

namespace App\Src\PaymentDomain\PaymentRefund\Model;

use App\Src\PaymentDomain\Money\Service\MoneyCast;
use App\Src\PaymentDomain\Payment\Model\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PaymentRefund extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'payment_refund';

    protected $dates = ['refund_at', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'value' => MoneyCast::class,
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
