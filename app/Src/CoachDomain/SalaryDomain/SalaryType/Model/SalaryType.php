<?php

namespace App\Src\CoachDomain\SalaryDomain\SalaryType\Model;

use App\Src\CoachDomain\SalaryDomain\Salary\Model\Salary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

//fixed - per hour
class SalaryType extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    const FIXED_ID = 1;

    const PER_HOUR_ID = 2;

    protected $table = 'salary_type';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function salary()
    {
        return $this->hasMany(Salary::class);
    }

    public function isFixed(): bool
    {
        return $this->id == self::FIXED_ID;
    }
}
