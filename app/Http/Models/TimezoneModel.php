<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimezoneModel extends Model
{
    use HasFactory;

    protected $table = 'timezone';

    protected $primaryKey = 'id';
}