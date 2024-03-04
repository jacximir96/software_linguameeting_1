<?php

namespace App\Src\StudentDomain\StudentHelp\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class StudentHelpType extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'student_help_type';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function help()
    {
        return $this->hasMany(StudentHelp::class);
    }
}
