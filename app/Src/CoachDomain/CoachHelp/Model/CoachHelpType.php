<?php

namespace App\Src\CoachDomain\CoachHelp\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class CoachHelpType extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'coach_help_type';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function help()
    {
        return $this->hasMany(CoachHelp::class);
    }
}
