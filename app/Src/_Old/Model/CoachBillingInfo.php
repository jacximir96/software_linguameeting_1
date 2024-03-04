<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachBillingInfo extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_coach_billing_info';

    protected $primaryKey = 'id_country';
}
