<?php

namespace App\Src\ExperienceDomain\ExperienceRegister\Model;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\PaymentDomain\Money\Service\MoneyCast;
use App\Src\PaymentDomain\Payment\Model\Payment;
use App\Src\PaymentDomain\PaymentDetail\Model\PaymentDetail;
use App\Src\Shared\Model\HashIdable;
use App\Src\Shared\Model\Morpheable;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ExperienceRegister extends Model implements Auditable, Morpheable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    const MORPH = 'experience_register';

    protected $table = 'experience_register';

    protected $dates = ['registered_at', 'joined_at', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'price' => MoneyCast::class,
    ];

    public function experience()
    {
        return $this->belongsTo(Experience::class);
    }

    public function payment()
    {
        return $this->paymentDetail->payment ?? null;
    }

    public function paymentDetail()
    {
        return $this->morphOne(PaymentDetail::class, 'payable');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isAttendance(): bool
    {
        return (bool) $this->attendance;
    }

    public function hasJoinedAt(): bool
    {
        return ! is_null($this->joined_at);
    }

    public function morphType(): string
    {
        return self::MORPH;
    }

    public function isUser(User $user): bool
    {
        return $this->user_id == $user->id;
    }
}
