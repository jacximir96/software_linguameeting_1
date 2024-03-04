<?php

namespace App\Src\CoachDomain\SalaryDomain\Discount\Model;

use App\Src\CoachDomain\SalaryDomain\DiscountType\Model\DiscountType;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\PaymentDomain\Money\Service\MoneyCast;
use App\Src\Shared\Model\HashIdable;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Discount extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    protected $table = 'salary_discount';

    protected $dates = ['date', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'value' => MoneyCast::class,
    ];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function session(){
        return $this->belongsTo(Session::class)->withTrashed();
    }

    public function type()
    {
        return $this->belongsTo(DiscountType::class, 'type_id');
    }

    public function hasComments(): bool
    {
        return ! empty(trim($this->comments));
    }
}
