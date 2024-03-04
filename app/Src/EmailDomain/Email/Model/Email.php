<?php

namespace App\Src\EmailDomain\Email\Model;

use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Email extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'email';

    protected $dates = ['send_at', 'created_at', 'updated_at', 'deleted_at'];

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
