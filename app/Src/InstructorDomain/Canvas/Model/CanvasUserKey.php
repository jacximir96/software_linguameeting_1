<?php

namespace App\Src\InstructorDomain\Canvas\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Src\UserDomain\User\Model\User;

class CanvasUserKey extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'canvas_user_key';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
