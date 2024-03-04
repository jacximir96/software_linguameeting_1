<?php

namespace App\Src\CoachDomain\Substitution\Model;

use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Substitution extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'coach_substitution';

    protected $dates = ['date_subsitution', 'created_at', 'updated_at', 'deleted_at'];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function substitute()
    {
        return $this->belongsTo(User::class, 'substitute_id');
    }
}
