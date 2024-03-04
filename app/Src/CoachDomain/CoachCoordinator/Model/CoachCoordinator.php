<?php

namespace App\Src\CoachDomain\CoachCoordinator\Model;

use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class CoachCoordinator extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'coach_coordinator';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function coordinator()
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }
}
