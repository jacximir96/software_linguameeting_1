<?php
namespace App\Src\CourseDomain\Section\Event;

use App\Src\CourseDomain\Course\Service\CourseChanges;
use App\Src\CourseDomain\Section\Service\SectionChanges;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class ChangeSectionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private User $user;

    private SectionChanges $sectionChanges;

    public function __construct(User $user, SectionChanges $sectionChanges)
    {
        $this->user = $user;
        $this->sectionChanges = $sectionChanges;
    }

    public function user():User{
        return $this->user;
    }

    public function sectionChanges ():SectionChanges{
        return $this->sectionChanges;
    }
}
