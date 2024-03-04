<?php

namespace App\Src\CoachDomain\CoachInfo\Model;

use App\Src\CoachDomain\Level\Model\Level;
use App\Src\Shared\Model\ValueObject\Url;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class CoachInfo extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'coach_info';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'coach_level_id')->withTrashed();
    }

    public function isTrainee(): bool
    {
        return $this->is_trainee;
    }

    public function isPayer(): bool
    {
        return $this->is_payer;
    }

    public function hasUrlVideo():bool{

        if (is_null($this->url_video)){
            return false;
        }

        return filter_var($this->url_video, FILTER_VALIDATE_URL);
    }

    public function urlVideo ():Url{
        return new Url($this->url_video);
    }


}
