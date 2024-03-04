<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniversityModel extends Model
{
    use HasFactory;

    protected $table = 'university';

    protected $primaryKey = 'id';
}