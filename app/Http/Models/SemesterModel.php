<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemesterModel extends Model
{
    use HasFactory;

    protected $table = 'semester';

    protected $primaryKey = 'id';
}