<?php

namespace App\Src\ConversationGuideDomain\ChapterFile\Model;

use App\Src\ConversationGuideDomain\Chapter\Model\Chapter;
use App\Src\File\Model\File;
use App\Src\File\Service\Fileable;
use App\Src\Shared\Model\HashIdable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class GuideChapterFile extends Model implements File, Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, Fileable, HashIdable;

    const KEY_PATH = 'guide_chaptar_file';

    protected $table = 'conversation_guide_chapter_file';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function keyPath(): string
    {
        return self::KEY_PATH;
    }
}
