<?php

namespace App\Src\CoachDomain\SalaryDomain\Salary\Model;

use App\Src\CoachDomain\SalaryDomain\SalaryType\Model\SalaryType;
use App\Src\PaymentDomain\Money\Service\MoneyCast;
use App\Src\Shared\Model\HashIdable;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Salary extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    protected $table = 'salary_coach';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'value' => MoneyCast::class,
        'extra_coordinator' => MoneyCast::class,
    ];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function type()
    {
        return $this->belongsTo(SalaryType::class, 'salary_type_id');
    }

    public function hasExtraCoordinator(): bool
    {
        return ! is_null($this->attributes['amount_extra_coordinator']);
    }
}
