<?php

namespace App\Src\InstructorDomain\TeachingAssistant\Model;

use App\Src\Shared\Model\HashIdable;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class TeachingAssistant extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    protected $table = 'teaching_assistant';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id')->withTrashed();
    }

    public function assistant()
    {
        return $this->belongsTo(User::class, 'assistant_id')->withTrashed();
    }
}
