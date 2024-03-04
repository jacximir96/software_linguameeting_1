<?php

namespace App\Src\StudentDomain\MakeupType\Model;

use App\Src\StudentDomain\Makeup\Model\Makeup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MakeupType extends Model implements Auditable
{
    const SLUG_CF = 'coaching-form';

    const SLUG_MANAGER = 'manager';

    const SLUG_INSTRUCTOR = 'instructor';

    const SLUG_PURCHASED = 'purchased';

    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'makeup_type';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function makeup()
    {
        return $this->hasMany(Makeup::class);
    }
}
