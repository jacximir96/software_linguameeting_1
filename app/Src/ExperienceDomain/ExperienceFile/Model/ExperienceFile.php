<?php

namespace App\Src\ExperienceDomain\ExperienceFile\Model;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\File\Model\File;
use App\Src\File\Service\Fileable;
use App\Src\File\Service\Path;
use App\Src\File\Service\PathBuilder;
use App\Src\Shared\Model\HashIdable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ExperienceFile extends Model implements Auditable, File
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, Fileable, HashIdable;

    const KEY_PATH = 'experience_file';

    protected $table = 'experience_file';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function request()
    {
        return $this->belongsTo(Experience::class);
    }

    public function type()
    {
        return $this->belongsTo(ExperienceFileType::class, 'experience_file_type_id');
    }

    public function isOrder(int $order): bool
    {
        return $this->order == $order;
    }

    public function keyPath(): string
    {
        return self::KEY_PATH;
    }

    public function path(): Path
    {
        $pathBuilder = app(PathBuilder::class);

        return $pathBuilder->buildAssetUrl($this->keyPath(), $this->filename());
    }
}
