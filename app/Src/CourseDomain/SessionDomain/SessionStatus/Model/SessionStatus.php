<?php

namespace App\Src\CourseDomain\SessionDomain\SessionStatus\Model;

use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class SessionStatus extends Model implements Auditable
{
    const SLUG_UNSPECIFIED = 'unspecified';

    const SLUG_ATTENDANCE = 'attendance';

    const SLUG_MISSED = 'missed';

    const ID_ATTENDANCE = 2;

    const ID_MISSED = 3;

    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'session_status';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function enrollmentSession()
    {
        return $this->hasMany(Session::class);
    }

    public function session()
    {
        return $this->hasMany(Session::class);
    }

    public function colorCssClass(): string
    {

        if ($this->slug == self::SLUG_ATTENDANCE) {
            return 'text-success';
        } elseif ($this->slug == self::SLUG_MISSED) {
            return 'text-danger';
        }

        return 'text-muted';
    }

    public function title(): string
    {

        if ($this->slug == self::SLUG_ATTENDANCE) {
            return 'Attended';
        } elseif ($this->slug == self::SLUG_MISSED) {
            return 'Missed';
        }

        return 'Unspecified';
    }

    public function isUnspecified(): bool
    {
        return $this->slug == self::SLUG_UNSPECIFIED;
    }

    public function isNotCelebrated(): bool
    {
        return $this->isUnspecified();
    }

    public function isCelebrated(): bool
    {
        return ! $this->isNotCelebrated();
    }

    public function isAttended(): bool
    {
        return $this->slug == self::SLUG_ATTENDANCE;
    }

    public function isMissed():bool{
        return $this->slug == self::SLUG_MISSED;
    }
}
