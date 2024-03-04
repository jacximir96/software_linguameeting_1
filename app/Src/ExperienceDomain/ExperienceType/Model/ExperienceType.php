<?php

namespace App\Src\ExperienceDomain\ExperienceType\Model;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\PaymentDomain\Money\Service\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ExperienceType extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'experience_type';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'price' => MoneyCast::class,
    ];

    public function course()
    {
        return $this->hasMany(Course::class);
    }

    public function isUnlimited(): bool
    {
        return (bool) $this->is_unlimited;
    }

    public function write(): string
    {

        if ($this->isUnlimited()) {
            return $this->name;
        }

        return $this->num_experiences.' Experience'.(($this->num_experiences == 1) ? '' : 's');
    }

    public function writeWithPrice(): string
    {

        $linguaMoney = app(LinguaMoney::class);

        $price = $linguaMoney->format($this->price);

        if ($this->isUnlimited()) {
            return $this->name.' ('.$price.')';
        }

        return $this->num_experiences.' Experience'.(($this->num_experiences == 1) ? '' : 's').' ('.$price.')';

    }
}
