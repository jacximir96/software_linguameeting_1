<?php

namespace App\Src\CoachDomain\SalaryDomain\Incentive\Model;

use App\Src\CoachDomain\SalaryDomain\IncentiveFrequency\Model\IncentiveFrequency;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Model\IncentiveType;
use App\Src\PaymentDomain\Money\Service\MoneyCast;
use App\Src\Shared\Model\HashIdable;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Incentive extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    protected $table = 'salary_incentive';

    protected $dates = ['date', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'value' => MoneyCast::class,
    ];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function frequency()
    {
        return $this->belongsTo(IncentiveFrequency::class, 'frequency_id');
    }

    public function type()
    {
        return $this->belongsTo(IncentiveType::class, 'type_id');
    }

    public function isMonthly(): bool
    {
        return (bool) $this->is_monthly;
    }

    public function hasComments(): bool
    {
        return ! empty(trim($this->comments));
    }
}
