<?php

namespace App\Src\CourseDomain\SessionDomain\ReplacedCoach\Model;

use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\Session\Service\Schedulable;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ReplacedCoach extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, Schedulable;

    protected $table = 'replaced_coach';

    protected $dates = ['replaced_at', 'created_at', 'updated_at', 'deleted_at'];

    public function session()
    {
        return $this->belongsTo(Session::class)->withTrashed();
    }

    public function replacedCoach()
    {
        return $this->belongsTo(User::class, 'replaced_coach_id')->withTrashed();
    }

    public function newCoach()
    {
        return $this->belongsTo(User::class, 'new_coach_id')->withTrashed();
    }
}
