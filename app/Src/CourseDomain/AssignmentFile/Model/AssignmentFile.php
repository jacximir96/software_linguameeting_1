<?php

namespace App\Src\CourseDomain\AssignmentFile\Model;

use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\File\Model\File;
use App\Src\File\Service\Fileable;
use App\Src\Shared\Model\HashIdable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class AssignmentFile extends Model implements File, Auditable
{
    use HasFactory, SoftDeletes, Fileable, \OwenIt\Auditing\Auditable, HashIdable;

    const KEY_PATH = 'assignment_file';

    protected $table = 'assignment_file';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function Assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function keyPath(): string
    {
        return self::KEY_PATH;
    }
}
