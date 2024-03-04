<?php

namespace App\Src\ConversationGuideDomain\Template\Model;

use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\ConversationGuideDomain\TemplateFile\Model\TemplateFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Template extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'template';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function guide()
    {
        return $this->belongsTo(ConversationGuide::class);
    }

    public function file()
    {
        return $this->hasOne(TemplateFile::class);
    }
}
