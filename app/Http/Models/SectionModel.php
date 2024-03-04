<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionModel extends Model
{
    use HasFactory;

    protected $table = 'section';

    protected $primaryKey = 'id';
}