<?php

namespace App\Src\CoachDomain\BillingInfo\Model;

use App\Src\Localization\Country\Model\Country;
use App\Src\PaymentDomain\AccountType\Model\AccountType;
use App\Src\PaymentDomain\Currency\Model\Currency;
use App\Src\PaymentDomain\MethodPayment\Model\MethodPayment;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class BillingInfo extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'coach_billing_info';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function methodPayment()
    {
        return $this->belongsTo(MethodPayment::class);
    }

    public function coach()
    {
        return $this->belongsTo(User::class);
    }

    public function hasPaymentInfo(): bool
    {
        return ! empty(trim($this->paid_info));
    }
}
