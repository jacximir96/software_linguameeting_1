<?php

namespace App\Src\HelpDomain\Issue\Model;

use App\Src\HelpDomain\IssueFile\Model\IssueFile;
use App\Src\HelpDomain\IssueType\Model\IssueType;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Issue extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'issue';

    protected $dates = ['sent_at', 'created_at', 'updated_at', 'deleted_at'];

    public function file()
    {
        return $this->hasMany(IssueFile::class);
    }

    public function type()
    {
        return $this->belongsTo(IssueType::class, 'issue_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
