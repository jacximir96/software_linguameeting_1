<?php

namespace App\Src\CoachDomain\Coach\Event;

use App\Src\UserDomain\User\Model\User;
use App\Src\ZoomDomain\ZoomRecording\Listener\CreateZoomUser;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CoachCreatedEvent implements CreateZoomUser
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private User $coach;

    private string $plainPassword;

    public function __construct(User $coach, string $plainPassword)
    {
        $this->coach = $coach;
        $this->plainPassword = $plainPassword;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    public function user(): User
    {
        return $this->coach;
    }

    public function plainPassword(): string
    {
        return $this->plainPassword;
    }
}
