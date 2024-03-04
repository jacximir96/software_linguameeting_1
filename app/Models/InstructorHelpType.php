<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstructorHelpType extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'instructor_help_type';

    public function helps()
    {
        return $this->hasMany(InstructorHelp::class, 'instructor_help_type_id');
    
    }


}
