<?php

namespace App\Src\ZoomDomain\ZoomRecording\Model;

use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\ZoomDomain\ZoomUser\Model\ZoomUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ZoomRecording extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    const STATUS_COMPLETED = 'completed';

    protected $table = 'zoom_recording';

    protected $dates = ['start', 'end', 'created_at', 'updated_at', 'deleted_at'];

    public function session()
    {
        return $this->belongsTo(Session::class)->withTrashed();
    }

    public function zoomUser()
    {
        return $this->belongsTo(ZoomUser::class)->withTrashed();
    }

    public function isCompleted(): bool
    {
        return $this->status == self::STATUS_COMPLETED;
    }
}
