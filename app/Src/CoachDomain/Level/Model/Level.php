<?php

namespace App\Src\CoachDomain\Level\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Level extends Model implements Auditable
{
    const ROOKIE = 4;

    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'coach_level';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
