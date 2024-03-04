<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachScheduleNew extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_coach_schedule_new';

    protected $primaryKey = 'schedule_id';

    public function university()
    {
        return $this->hasMany(University::class, 'id_country');
    }

    public function dayOfWeek(): int
    {

        try {

            return match ($this->day_week_schedule) {

                'Sun' => 0,
                'Mon' => 1,
                'Tue' => 2,
                'Wed' => 3,
                'Thu' => 4,
                'Fri' => 5,
                'Sat' => 6
            };
        } catch (\UnhandledMatchError $exception) {
            dd('Día no encontrado: '.$this->day_weeek_schedule);
        }
    }
}
