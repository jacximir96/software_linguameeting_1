<?php

namespace App\Src\CoachDomain\FeedbackDomain\ManagerEvaluationFile\Model;

use App\Src\CoachDomain\FeedbackDomain\ManagerEvaluation\Model\ManagerEvaluation;
use App\Src\File\Model\File;
use App\Src\File\Service\Fileable;
use App\Src\Shared\Model\HashIdable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ManagerEvaluationFile extends Model implements File, Auditable
{
    use HasFactory, SoftDeletes, Fileable, \OwenIt\Auditing\Auditable, HashIdable;

    const KEY_PATH = 'coach_evaluation';

    protected $table = 'manager_evaluation_file';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function evaluation()
    {
        return $this->belongsTo(ManagerEvaluation::class, 'evaluation_id');
    }

    public function keyPath(): string
    {
        return self::KEY_PATH;
    }
}
