<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuidesChapters extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_guides_chapters';

    protected $primaryKey = 'id_chapter';
}
