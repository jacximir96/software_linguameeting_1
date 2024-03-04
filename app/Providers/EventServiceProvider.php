<?php

namespace App\Providers;

use App\Src\CoachDomain\Coach\Event\CoachCreatedEvent;
use App\Src\CourseDomain\Course\Event\ChangeCourseEvent;
use App\Src\CourseDomain\Course\Listener\CourseNotificationListener;
use App\Src\CourseDomain\Section\Event\ChangeSectionEvent;
use App\Src\CourseDomain\Section\Listener\SectionNotificationListener;
use App\Src\NotificationDomain\Notification\Subscriber\WriteNotificationSubscriber;
use App\Src\UserDomain\User\Listener\LockUserListener;
use App\Src\ZoomDomain\ZoomRecording\Listener\CreateZoomUserListener;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Verified::class => [

        ],
        Lockout::class => [
            LockUserListener::class,
        ],
        CoachCreatedEvent::class => [
            CreateZoomUserListener::class,
        ],

        ChangeCourseEvent::class => [
            CourseNotificationListener::class,
        ],

        ChangeSectionEvent::class => [
            SectionNotificationListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
