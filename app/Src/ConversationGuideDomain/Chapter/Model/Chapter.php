<?php

namespace App\Src\ConversationGuideDomain\Chapter\Model;

use App\Src\ConversationGuideDomain\ChapterFile\Model\GuideChapterFile;
use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Chapter extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'conversation_guide_chapter';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function guide()
    {
        return $this->belongsTo(ConversationGuide::class);
    }

    public function file()
    {
        return $this->hasOne(GuideChapterFile::class, 'conversation_guide_chapter_id');
    }
}
