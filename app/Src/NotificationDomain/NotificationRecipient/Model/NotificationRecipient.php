<?php

namespace App\Src\NotificationDomain\NotificationRecipient\Model;

use App\Src\NotificationDomain\Notification\Model\Notification;
use App\Src\Shared\Model\HashIdable;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class NotificationRecipient extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    protected $table = 'notification_recipient';

    protected $dates = ['read_at', 'created_at', 'updated_at', 'deleted_at'];

    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hasBeenReaded(): bool
    {
        return ! is_null($this->read_at);
    }
}
