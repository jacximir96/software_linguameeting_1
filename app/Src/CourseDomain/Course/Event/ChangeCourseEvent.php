<?php
namespace App\Src\CourseDomain\Course\Event;

use App\Src\CourseDomain\Course\Service\CourseChanges;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class ChangeCourseEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private User $user;

    private CourseChanges $courseChanges;

    public function __construct(User $user, CourseChanges $courseChanges)
    {
        $this->user = $user;
        $this->courseChanges = $courseChanges;
    }

    public function user():User{
        return $this->user;
    }

    public function courseChanges ():CourseChanges{
        return $this->courseChanges;
    }
}
