<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbacksCoaches extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_feedbacks_coaches';

    protected $primaryKey = 'id_feed_coach';
}
