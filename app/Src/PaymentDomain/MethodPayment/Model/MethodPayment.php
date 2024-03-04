<?php

namespace App\Src\PaymentDomain\MethodPayment\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MethodPayment extends Model implements Auditable
{
    const ID_PAYPAL = 2;

    const ID_TRANSFER_WISE = 3;

    const ID_BANK_TRANSFER = 5;

    const ID_CREDIT_CARD = 6;

    const ID_CODE = 7;

    const ID_FREE = 8;

    const FREE = 'free';

    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'method_payment';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function isTransfer(): bool
    {
        return  ($this->id == self::ID_TRANSFER_WISE) or ($this->id == self::ID_BANK_TRANSFER);
    }

    public function isPaypal(): bool
    {
        return $this->id == self::ID_PAYPAL;
    }

    public function isCode(): bool
    {
        return $this->id == self::ID_CODE;
    }

    public function isCreditCard(): bool
    {
        return $this->id == self::ID_CREDIT_CARD;
    }
}
