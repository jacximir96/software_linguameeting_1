<?php

namespace App\Src\NotificationDomain\Notification\Model;


use App\Src\NotificationDomain\NotificationRecipient\Model\NotificationRecipient;
use App\Src\NotificationDomain\NotificationType\Model\NotificationType;
use App\Src\Shared\Model\HashIdable;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Notification extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    protected $table = 'notification';

    protected $dates = ['notification_at', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'extra' => 'array',
    ];

    public function notifier (){
        return $this->belongsTo(User::class, 'notifier_id');
    }

    public function type()
    {
        return $this->belongsTo(NotificationType::class, 'notification_type_id');
    }

    public function recipient()
    {
        return $this->hasMany(NotificationRecipient::class);
    }

    public function hasExtraKey():bool{
        return isset($this->extra['key']);
    }
}
