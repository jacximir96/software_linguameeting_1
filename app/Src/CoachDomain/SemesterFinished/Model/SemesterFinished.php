<?php

namespace App\Src\CoachDomain\SemesterFinished\Model;

use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class SemesterFinished extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'coach_semester_finished';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function finishedOne(): bool
    {
        return (bool) $this->finished_1;
    }

    public function finishedTwo(): bool
    {
        return (bool) $this->finished_2;
    }
}
