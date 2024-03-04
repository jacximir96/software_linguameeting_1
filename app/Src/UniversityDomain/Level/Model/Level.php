<?php

namespace App\Src\UniversityDomain\Level\Model;

use App\Src\UniversityDomain\University\Model\University;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Level extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'university_level';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function university()
    {
        return $this->hasMany(University::class);
    }
}
