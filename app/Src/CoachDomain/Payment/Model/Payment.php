<?php

namespace App\Src\CoachDomain\Payment\Model;

use App\Src\PaymentDomain\Money\Service\MoneyCast;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Payment extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'coach_payment';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'value' => MoneyCast::class,
    ];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function isPaid(): bool
    {
        return (bool) $this->is_paid;
    }
}
