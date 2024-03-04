<?php

namespace App\Src\ConversationGuideDomain\TemplateFile\Model;

use App\Src\ConversationGuideDomain\Template\Model\Template;
use App\Src\File\Model\File;
use App\Src\File\Service\Fileable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class TemplateFile extends Model implements File, Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, Fileable;

    const KEY_PATH = 'template_file';

    protected $table = 'template_file';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function keyPath(): string
    {
        return self::KEY_PATH;
    }
}
