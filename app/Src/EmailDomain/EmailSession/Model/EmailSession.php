<?php

namespace App\Src\EmailDomain\EmailSession\Model;

use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class EmailSession extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'email_session';

    protected $dates = ['date_send_mes', 'created_at', 'updated_at', 'deleted_at'];

    public function receiver()
    {
        return $this->belongsTo(User::class, 'id_user_receiver');
    }
}
