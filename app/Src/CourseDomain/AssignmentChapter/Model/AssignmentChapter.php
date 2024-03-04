<?php

namespace App\Src\CourseDomain\AssignmentChapter\Model;

use App\Src\ConversationGuideDomain\Chapter\Model\Chapter;
use App\Src\CourseDomain\Assignment\Model\Assignment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssignmentChapter extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'assignment_chapter';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function courseAssignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }
}
