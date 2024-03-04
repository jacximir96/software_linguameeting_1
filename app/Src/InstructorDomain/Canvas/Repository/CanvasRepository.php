<?php

namespace App\Src\InstructorDomain\Canvas\Repository;

use App\Src\InstructorDomain\Canvas\Model\CanvasCourse;
use App\Src\InstructorDomain\Canvas\Model\CanvasUserKey;
use App\Src\UserDomain\User\Model\User;
use App\Src\CourseDomain\Course\Model\Course;

/**
 * Description of CanvasRepository
 *
 * @author Sandra
 */
class CanvasRepository {
    //put your code here
    
    public function canvasInstructor (Course $course, User $user):?CanvasCourse{

        return CanvasCourse::query()
            ->where('course_id', $course->id)
            ->where('user_id',$user->id)
            ->first();
    }
    
    public function keys (User $user):?CanvasUserKey{
        
        return CanvasUserKey::query()
            ->where('user_id', $user->id)
            ->where('active',1)
            ->first();
        
    }
}
