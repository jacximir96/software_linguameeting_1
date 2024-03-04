<?php

namespace App\Src\NotificationDomain\NotificationLevel\Model;

use App\Src\NotificationDomain\NotificationType\Model\NotificationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class NotificationLevel extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'notification_level';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function type()
    {
        return $this->hasMany(NotificationType::class);
    }
}
