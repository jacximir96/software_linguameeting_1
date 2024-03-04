<?php

namespace App\Src\ZoomDomain\ZoomUser\Model;

use App\Src\UserDomain\User\Model\User;
use App\Src\ZoomDomain\ZoomRecording\Model\ZoomRecording;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ZoomUser extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'zoom_user';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recording()
    {
        return $this->hasMany(ZoomRecording::class);
    }
}
