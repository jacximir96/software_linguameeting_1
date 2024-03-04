<?php

namespace App\Src\CoachDomain\SalaryDomain\IncentiveFrequency\Model;

use App\Src\CoachDomain\SalaryDomain\Incentive\Model\Incentive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class IncentiveFrequency extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    const PUNTUAL_ID = 1;

    const MONTHLY_ID = 2;

    protected $table = 'salary_incentive_frequency';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function incentive()
    {
        return $this->hasMany(Incentive::class, 'frequency_id');
    }
}
