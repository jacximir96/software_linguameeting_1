<?php

namespace App\Src\StudentDomain\ExtraSessionType\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ExtraSessionType extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'extra_session_type';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
