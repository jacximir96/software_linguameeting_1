<?php

namespace App\Src\ExperienceDomain\ExperienceRegisterPublic\Model;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\PaymentDomain\MethodPayment\Model\MethodPayment;
use App\Src\PaymentDomain\Money\Service\MoneyCast;
use App\Src\Shared\Model\Morpheable;
use App\Src\UserDomain\UserPublic\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ExperienceRegisterPublic extends Model implements Auditable, Morpheable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    const MORPH = 'experience_register_public';

    protected $table = 'experience_register_public';

    protected $dates = ['registered_at', 'joined_at', 'payment_at', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'price' => MoneyCast::class,
    ];

    public function experience()
    {
        return $this->belongsTo(Experience::class);
    }

    public function methodPayment()
    {
        return $this->belongsTo(MethodPayment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function writeFullName(): string
    {
        return $this->lastname.', '.$this->name;
    }

    public function morphType(): string
    {
        return self::MORPH;
    }
}
