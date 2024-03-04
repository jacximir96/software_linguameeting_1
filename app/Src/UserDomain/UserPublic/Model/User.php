<?php

namespace App\Src\UserDomain\UserPublic\Model;

use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\PaymentDomain\Payment\Model\Payment;
use App\Src\UserDomain\User\Model\UserAccess;
use App\Src\UserDomain\User\Model\UserPayable;
use App\Src\UserDomain\UserPublic\Model\Traits\Printable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Model implements Auditable, UserPayable, UserAccess
{
    use SoftDeletes , \OwenIt\Auditing\Auditable, Printable;

    private TimeZone $timezone;

    protected $table = 'user_public';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function userPayment()
    {
        return $this->hasMany(Payment::class, 'payer_public_id');
    }

    public function setTimezone(TimeZone $timeZone)
    {
        $this->timezone = $timeZone;
    }

    public function userTimezone(): TimeZone
    {
        return $this->timezone;
    }

    public function writeFullName(): string
    {
        return $this->lastname.', '.$this->name;
    }

    public function isRegistered(): TimeZone
    {
        return false;
    }

    public function isPublic(): string
    {
        return true;
    }
}
