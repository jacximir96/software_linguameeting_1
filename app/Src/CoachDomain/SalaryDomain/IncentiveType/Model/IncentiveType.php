<?php

namespace App\Src\CoachDomain\SalaryDomain\IncentiveType\Model;

use App\Src\CoachDomain\SalaryDomain\Incentive\Model\Incentive;
use App\Src\Shared\Model\HashIdable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class IncentiveType extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    protected $table = 'salary_incentive_type';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function incentive()
    {
        return $this->hasMany(Incentive::class, 'type_id');
    }
}
