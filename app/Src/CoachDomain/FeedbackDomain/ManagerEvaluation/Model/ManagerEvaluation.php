<?php

namespace App\Src\CoachDomain\FeedbackDomain\ManagerEvaluation\Model;

use App\Src\CoachDomain\FeedbackDomain\ManagerEvaluationFile\Model\ManagerEvaluationFile;
use App\Src\Shared\Model\HashIdable;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


//linguameeting -> coach (file)
class ManagerEvaluation extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    protected $table = 'manager_evaluation';

    protected $dates = ['evaluation_at', 'created_at', 'updated_at', 'deleted_at'];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function file()
    {
        return $this->hasMany(ManagerEvaluationFile::class, 'evaluation_id');
    }

    public function coachIsOwner(User $coach): bool
    {
        return $this->coach_id = $coach->id;
    }
}
