<?php

namespace App\Src\MessagingDomain\File\Model;

use App\Src\File\Model\File;
use App\Src\File\Service\Fileable;
use App\Src\File\Service\Path;
use App\Src\File\Service\PathBuilder;
use App\Src\MessagingDomain\Message\Model\Message;
use App\Src\Shared\Model\HashIdable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MessageFile extends Model implements Auditable, File
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, Fileable, HashIdable;

    const KEY_PATH = 'message_file';

    protected $table = 'message_file';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function message()
    {
        return $this->belongsTo(Message::class);
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
