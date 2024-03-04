<?php

namespace App\Src\ExperienceDomain\ExperienceComment\Model;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class ExperienceComment extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    const DEFAULT_RATE = 5;

    protected $table = 'experience_comment';

    protected $dates = ['commented_at', 'created_at', 'updated_at', 'deleted_at'];

    public function experience()
    {
        return $this->belongsTo(Experience::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function writeFullName()
    {

        if ($this->user) {
            return $this->user->writeFullName();
        }

        return $this->lastname.', '.$this->name;
    }

    public function writeEmail()
    {

        if ($this->user) {
            return $this->user->email;
        }

        return $this->email;
    }
}
