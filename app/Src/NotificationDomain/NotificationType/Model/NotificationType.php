<?php

namespace App\Src\NotificationDomain\NotificationType\Model;

use App\Src\NotificationDomain\Notification\Model\Notification;
use App\Src\NotificationDomain\NotificationLevel\Model\NotificationLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class NotificationType extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    const REFUND_ERROR_ID = 16;

    protected $table = 'notification_type';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function level()
    {
        return $this->belongsTo(NotificationLevel::class, 'notification_level_id');
    }

    public function notification()
    {
        return $this->hasMany(Notification::class);
    }
}
