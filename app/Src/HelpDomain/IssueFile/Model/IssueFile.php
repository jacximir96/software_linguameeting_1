<?php

namespace App\Src\HelpDomain\IssueFile\Model;

use App\Src\File\Model\File;
use App\Src\File\Service\Fileable;
use App\Src\File\Service\PathBuilder;
use App\Src\Shared\Model\ValueObject\Url;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class IssueFile extends Model implements File, Auditable
{
    use HasFactory, SoftDeletes, Fileable, \OwenIt\Auditing\Auditable;

    const KEY_PATH = 'issue_file';

    protected $table = 'issue_file';

    protected $dates = ['sent_at', 'created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function keyPath(): string
    {
        return self::KEY_PATH;
    }

    public function url(): Url
    {

        $pathBuilder = app(PathBuilder::class);

        $path = $pathBuilder->buildAssetUrl($this->keyPath(), $this->filename());

        return new Url($path->get());
    }
}
