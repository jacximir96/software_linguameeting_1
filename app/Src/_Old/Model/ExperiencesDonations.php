<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperiencesDonations extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_experiences_donations';

    protected $primaryKey = 'id_donation';
}
