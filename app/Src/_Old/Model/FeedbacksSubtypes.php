<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbacksSubtypes extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_feedbacks_subtypes';

    protected $primaryKey = 'id_feed_subtype';
}
