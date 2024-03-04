<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbacksObservations extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_feedbacks_observations';

    protected $primaryKey = 'id_feed_obs';
}
