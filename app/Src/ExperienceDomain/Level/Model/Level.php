<?php
namespace App\Src\ExperienceDomain\Level\Model;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\Shared\Model\HashIdable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Level extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    const KEY_PATH = 'experience_level';

    protected $table = 'experience_level';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function experience(){
        return $this->hasMany(Experience::class);
    }
}
