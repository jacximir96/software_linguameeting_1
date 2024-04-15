<?php

namespace App\Src\UserDomain\User\Model;

use App\Src\CourseDomain\CourseCoach\Model\CourseCoach;
use App\Src\CourseDomain\DenyAccess\Model\DenyAccess;
use App\Src\HelpDomain\Issue\Model\Issue;
use App\Src\Localization\Country\Model\Country;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\Shared\Model\HashIdable;
use App\Src\UserDomain\ProfileImage\Model\ProfileImage;
use App\Src\UserDomain\User\Model\Traits\Coach;
use App\Src\UserDomain\User\Model\Traits\Experience;
use App\Src\UserDomain\User\Model\Traits\Instructor;
use App\Src\UserDomain\User\Model\Traits\Language;
use App\Src\UserDomain\User\Model\Traits\Messaging;
use App\Src\UserDomain\User\Model\Traits\Notification;
use App\Src\UserDomain\User\Model\Traits\Payment;
use App\Src\UserDomain\User\Model\Traits\Printable;
use App\Src\UserDomain\User\Model\Traits\Rol;
use App\Src\UserDomain\User\Model\Traits\Status;
use App\Src\UserDomain\User\Model\Traits\Student;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements Auditable, MustVerifyEmail, UserPayable, UserAccess
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles , \OwenIt\Auditing\Auditable, Impersonate, \Illuminate\Auth\MustVerifyEmail;
    use Coach, Instructor, Language, Printable, Rol, Student, Status, Messaging, Payment, Experience, HashIdable, Notification;

    protected $table = 'user';

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function countryLive()
    {
        return $this->belongsTo(Country::class, 'country_live_id');
    }

    public function coaches()
    {
        return $this->belongsTo(CourseCoach::class,'id', 'coach_id');
    }

    public function denyAccess()
    {
        return $this->hasMany(DenyAccess::class);
    }

    public function issue()
    {
        return $this->hasMany(Issue::class);
    }

    public function profileImage()
    {
        return $this->hasOne(ProfileImage::class);
    }

    public function timezone()
    {
        return $this->belongsTo(TimeZone::class);
    }

    public function timezonename():string{
        return $this->timezone->name;
    }

    public function setPasswordAttribute($value)
    {
        if (app()->runningInConsole()) {
            $this->attributes['password'] = $value;

            return;
        }

        $this->attributes['password'] = bcrypt($value);
    }

    public function getFullNameAttribute(): string
    {
        return $this->lastname.', '.$this->name;
    }

    public function hasInternalComment(): bool
    {
        if (is_null($this->internal_comment)) {
            return false;
        }

        return ! empty($this->internal_comment);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }

    public function isSame(User $user): bool
    {
        return $this->id == $user->id;
    }

    public function hasEmailVerified():bool{
        return !is_null($this->email_verified_at);
    }

    public function userTimezone(): TimeZone
    {
        return $this->timezone;
    }

    public function isRegistered(): TimeZone
    {
        return true;
    }

    public function isPublic(): string
    {
        return false;
    }

    public function countryLiveOrOrigin (){

        if ($this->countryLive){
            return $this->countryLive;
        }

        return $this->country;

    }
}
