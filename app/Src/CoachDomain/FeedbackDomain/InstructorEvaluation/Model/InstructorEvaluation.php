<?php

namespace App\Src\CoachDomain\FeedbackDomain\InstructorEvaluation\Model;

use App\Src\Shared\Model\HashIdable;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

//instructor -> coach
class InstructorEvaluation extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    protected $table = 'instructor_evaluation';

    protected $dates = ['evaluation_at', 'created_at', 'updated_at', 'deleted_at'];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
}
