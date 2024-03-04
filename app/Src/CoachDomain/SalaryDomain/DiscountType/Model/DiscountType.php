<?php

namespace App\Src\CoachDomain\SalaryDomain\DiscountType\Model;

use App\Src\CoachDomain\SalaryDomain\Discount\Model\Discount;
use App\Src\Shared\Model\HashIdable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class DiscountType extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    protected $table = 'salary_discount_type';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function discount()
    {
        return $this->hasMany(Discount::class, 'type_id');
    }
}
