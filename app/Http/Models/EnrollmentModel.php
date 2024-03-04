<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollmentModel extends Model
{
    use HasFactory;

    protected $table = 'enrollment';

    protected $primaryKey = 'id';
}