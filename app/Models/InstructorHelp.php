<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstructorHelp extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'instructor_help'; 
    public function type()
    {
        return $this->belongsTo(InstructorHelpType::class, 'instructor_help_type_id');
    }
}
