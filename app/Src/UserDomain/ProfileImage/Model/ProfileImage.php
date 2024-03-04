<?php

namespace App\Src\UserDomain\ProfileImage\Model;

use App\Src\File\Model\File;
use App\Src\File\Service\Fileable;
use App\Src\File\Service\Path;
use App\Src\File\Service\PathBuilder;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ProfileImage extends Model implements File, Auditable
{
    use HasFactory, SoftDeletes, Fileable, \OwenIt\Auditing\Auditable;

    const KEY_PATH = 'profile_image';

    protected $table = 'profile_image';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function keyPath(): string
    {
        return self::KEY_PATH;
    }

    public function url(): Path
    {

        $pathBuilder = app(PathBuilder::class);

        return $pathBuilder->buildAssetUrl($this->keyPath(), $this->filename());
    }
}
