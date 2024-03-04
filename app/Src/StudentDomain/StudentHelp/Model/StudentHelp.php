<?php

namespace App\Src\StudentDomain\StudentHelp\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class StudentHelp extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'student_help';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function type()
    {
        return $this->belongsTo(StudentHelpType::class, 'student_help_type_id');
    }
}
