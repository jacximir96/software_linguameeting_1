<?php

namespace App\Src\InstructorDomain\InstructorHelp\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class InstructorHelpType extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'instructor_help_type';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function help()
    {
        return $this->hasMany(InstructorHelp::class);
    }
}
