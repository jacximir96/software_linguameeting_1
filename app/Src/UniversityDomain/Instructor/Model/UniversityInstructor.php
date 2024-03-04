<?php

namespace App\Src\UniversityDomain\Instructor\Model;

use App\Src\UniversityDomain\University\Model\University;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class UniversityInstructor extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'university_instructor';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }
}
