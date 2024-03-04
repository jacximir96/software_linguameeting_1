<?php

namespace App\Src\CoachDomain\CoachHelp\Model;

use App\Src\Shared\Model\HashIdable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class CoachHelp extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    protected $table = 'coach_help';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function type()
    {
        return $this->belongsTo(CoachHelpType::class, 'coach_help_type_id');
    }
}
