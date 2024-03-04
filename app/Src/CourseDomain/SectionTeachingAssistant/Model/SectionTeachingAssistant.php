<?php

namespace App\Src\CourseDomain\SectionTeachingAssistant\Model;

use App\Src\CourseDomain\Section\Model\Section;
use App\Src\Shared\Model\HashIdable;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class SectionTeachingAssistant extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    protected $table = 'section_teacher_assistant';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class);
    }
}
