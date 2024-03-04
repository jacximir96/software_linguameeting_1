<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionModel extends Model
{
    use HasFactory;

    protected $table = 'session';

    protected $primaryKey = 'id';
}