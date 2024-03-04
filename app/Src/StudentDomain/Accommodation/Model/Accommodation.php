<?php

namespace App\Src\StudentDomain\Accommodation\Model;

use App\Src\StudentDomain\AccommodationType\Model\AccommodationType;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Accommodation extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'accommodation';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function type()
    {
        return $this->belongsTo(AccommodationType::class, 'accommodation_type_id')->withTrashed();
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function hasDescription(): bool
    {
        return ! empty($this->description);
    }
}
