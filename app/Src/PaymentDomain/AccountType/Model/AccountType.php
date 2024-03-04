<?php

namespace App\Src\PaymentDomain\AccountType\Model;

use App\Src\CoachDomain\BillingInfo\Model\BillingInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class AccountType extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    const CHECKING_ACCOUNT_ID = 1;

    const SAVING_ACCOUNT = 2;

    protected $table = 'account_type';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function billingInfo()
    {
        return $this->hasMany(BillingInfo::class);
    }
}
