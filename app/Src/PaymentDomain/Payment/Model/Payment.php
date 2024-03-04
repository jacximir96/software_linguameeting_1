<?php
namespace App\Src\PaymentDomain\Payment\Model;

use App\Src\PaymentDomain\MethodPayment\Model\MethodPayment;
use App\Src\PaymentDomain\Money\Service\MoneyCast;
use App\Src\PaymentDomain\PaymentDetail\Model\PaymentDetail;
use App\Src\PaymentDomain\PaymentRefund\Model\PaymentRefund;
use App\Src\RegisterCodeDomain\RegisterCode\Model\RegisterCode;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class Payment extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'payment';

    protected $dates = ['paid_at', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'value' => MoneyCast::class,
    ];

    public function methodPayment()
    {
        return $this->belongsTo(MethodPayment::class);
    }

    public function detail()
    {
        return $this->hasMany(PaymentDetail::class, 'payment_id');
    }

    public function payable(): MorphTo
    {
        return $this->morphTo()->withTrashed();
    }

    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_id')->withTrashed();
    }

    public function publicPayer()
    {
        return $this->belongsTo(\App\Src\UserDomain\UserPublic\Model\User::class, 'payer_public_id')->withTrashed();
    }

    public function registerCode()
    {
        return $this->hasOne(RegisterCode::class, 'id', 'register_code_id');
    }

    public function refund()
    {
        return $this->hasOne(PaymentRefund::class, 'payment_id');
    }

    public function isFromRegisterUser()
    {
        return ! is_null($this->payer);
    }

    public function isPublicUser()
    {
        return ! is_null($this->publicPayer);
    }

    public function writeFullName(): string
    {

        if ($this->isFromRegisterUser()) {
            return $this->payer->writeFullName();
        }

        return $this->publicPayer->writeFullName();
    }

    public function hasDetailWithEnrollment():bool{

        foreach ($this->detail as $detail){
            if ($detail->isEnrollment()){
                return true;
            }
        }

        return false;
    }

    public function enrollment ():?Enrollment{

        foreach ($this->detail as $detail){

            if ($detail->isEnrollment()){
                return $detail->enrollment();
            }
        }

        return null;
    }

    public function hasRefund ():bool{
        return !is_null($this->refund);
    }

    public function hasTransactionId ():bool{
        return !empty($this->transaction_id);
    }
}
