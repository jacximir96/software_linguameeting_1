<?php

namespace App\Src\TimeDomain\Semester\Model;

use App\Src\CoachDomain\Occupation\Model\Occupation;
use App\Src\CourseDomain\Course\Model\Course;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Semester extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    const ID_FALL = 1;
    const ID_SPRING = 2;
    const ID_SUMMER = 3;

    protected $table = 'semester';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function coachOccupation()
    {
        return $this->hasMany(Occupation::class);
    }

    public function course()
    {
        return $this->hasMany(Course::class);
    }

    public function period ():CarbonPeriod{

        $year = date('Y');

        if ($this->id == self::ID_FALL){
            $startDate = Carbon::parse($year.-'08-01');
            $endDate = Carbon::parse($year.'-12-31');
        }
        elseif ($this->id == self::ID_SPRING){
            $startDate = Carbon::parse($year.'-01-01');
            $endDate = Carbon::parse($year.'-05-31');
        }
        else{
            $startDate = Carbon::parse($year.'-06-01');
            $endDate = Carbon::parse($year.'-07-31');
        }

        return CarbonPeriod::create($startDate, $endDate);
    }
}
