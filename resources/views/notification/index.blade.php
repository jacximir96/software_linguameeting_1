@extends('layouts.app')

@section('content')


    @if ( ! $user->isStudent())
        <div class="card">
            <div class="card-header p-2 d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
               <span class="">
                    <i class="fas fa-search me-1"></i>
                    Search Notifications
                </span>
                <span>{{$timezone->name}}</span>
            </div>
            <div class="card-body">
                @include('notification.search_form')
            </div>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-bell me-1"></i>
                Notifications
            </span>

        </div>
        <div class="card-body">

            {{$notifications->appends(request()->except(['_token']))->links()}}

            <table id="" class="table table-hover">
                <thead>
                <tr>
                    <th class="w-5">Level</th>
                    <th class="w-10">Type</th>
                    <th class="w-10">User</th>
                    <th class="w-20">Content</th>
                    <th class="w-10">Before</th>
                    <th class="w-10">After</th>

                    <th class="w-10">Notification at</th>
                    <th class="w-10">Readed at</th>
                    <th class="w-5">Action</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($notifications as $notification)

                    @if ( ! $notification->hasExtraKey())
                        @continue
                    @endif

                    @php $printer = $printerBuilder->build($notification) @endphp

                    @if (is_null($printer))
                        @continue
                    @endif

                    <tr>
                        <td>
                            <span class="d-inline-block p-2 rounded" style="background-color: {{$notification->type->level->color}}">
                                {{$notification->type->level->name}}
                            </span>
                        </td>
                        <td>
                            <span class="d-block fw-bold">{{$notification->type->name}}</span>
                            <span class="d-block">{{$notification->type->description}}</span>
                        </td>
                        <td>
                            {{$notification->notifier->writeFullName()}}
                        </td>
                        <td>
                            <div class="long-text" data-expander-slice="300">
                                {!! $notification->content !!}
                            </div>

                            <div class="">

                                @switch($printer->key())
                                    @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Course\CourseDatesNotifier::KEY)
                                    @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Course\SemesterNotifier::KEY)
                                    @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Course\NameNotifier::KEY)
                                    @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Course\LanguageNotifier::KEY)
                                    @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Course\ConversationGuideNotifier::KEY)
                                    @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Course\IsFreeNotifier::KEY)
                                    @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Course\StudentClassNotifier::KEY)
                                    @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Course\DiscountNotifier::KEY)
                                    @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Course\ConversationPackageNotifier::KEY)
                                    @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Course\HolidaysNotifier::KEY)
                                    @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Course\CoachingWeeksNotifier::KEY)
                                    @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Course\CourseCreatedNotifier::KEY)

                                    @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Section\SectionCreatedNotifier::KEY)
                                        @include('notification.cells.university_course', ['printer' => $printer])
                                        @break
                                    @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Section\InstructorNotifier::KEY)
                                        @include('notification.cells.university_course_section', ['printer' => $printer])
                                        @break

                                    @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Enrollment\SectionChangedNotifier::KEY)
                                        @include('notification.cells.enrollment_section', ['printer' => $printer])
                                        @break
                                    @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Enrollment\CourseChangedNotifier::KEY)
                                        @include('notification.cells.enrollment_section', ['printer' => $printer])
                                        @break
                                @endswitch
                            </div>
                        </td>
                        <td>
                            @switch($printer->key())
                                @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Course\CourseCreatedNotifier::KEY)
                                @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Section\SectionCreatedNotifier::KEY)
                                    @break
                                @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Course\HolidaysNotifier::KEY)

                                    @foreach ($printer->before() as $value)
                                        @if ($value->field() == 'deleted')
                                            <p class="m-0 mb-1">
                                                <span class="fw-bold d-block">New Holiday</span>
                                                <span class="text-new text-success">{{$value->value()}}</span>
                                            </p>
                                        @endif
                                    @endforeach

                                    @break
                                @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Course\CoachingWeeksNotifier::KEY)
                                    @foreach ($printer->before() as $value)

                                        @if ($value->field() == 'deleted')
                                            <p class="m-0 mb-1">
                                                <span class="fw-bold d-block">Week Deleted</span>
                                                <span class="text-danger">{{$value->value()}}</span>
                                            </p>
                                        @endif
                                    @endforeach


                                    @break

                                @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Enrollment\SectionChangedNotifier::KEY)
                                        {{$printer->sectionBefore()}}
                                @break;
                                @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Enrollment\CourseChangedNotifier::KEY)
                                    {{$printer->sectionBefore()}}
                                @break;
                                @default

                                    @foreach ($printer->before() as $value)

                                        <p class="m-0 mb-1">
                                            <span class="fw-bold d-block">{{$value->field()}}</span>
                                            <span class="text-danger">{{$value->value()}}</span>
                                        </p>
                                    @endforeach
                            @endswitch

                        </td>
                        <td>

                            @switch($printer->key())
                                @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Course\HolidaysNotifier::KEY)
                                    @foreach ($printer->before() as $value)
                                        @if ($value->field() == 'new')
                                            <p class="m-0 mb-1">
                                                <span class="fw-bold d-block">New Holiday</span>
                                                <span class="text-new text-success">{{$value->value()}}</span>
                                            </p>
                                        @endif
                                    @endforeach

                                    @break
                                @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Course\CoachingWeeksNotifier::KEY)
                                    @foreach ($printer->before() as $value)

                                        @if ($value->field() == 'new')
                                            <p class="m-0 mb-1">
                                                <span class="fw-bold d-block">New Week</span>
                                                <span class="text-danger">{{$value->value()}}</span>
                                            </p>
                                        @endif
                                    @endforeach


                                    @break
                                @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Enrollment\SectionChangedNotifier::KEY)
                                    {{$printer->sectionAfter()}}
                                    @break;
                                @case(\App\Src\NotificationDomain\Notification\Service\Notifiers\Enrollment\CourseChangedNotifier::KEY)
                                    {{$printer->sectionAfter()}}
                                @break;
                                @default

                                    @foreach ($printer->after() as $value)
                                        <p class="m-0 mb-1">
                                            <span class="fw-bold d-block">{{$value->field()}}</span>
                                            <span class="text-success">{{$value->value()}}</span>
                                        </p>
                                    @endforeach
                            @endswitch

                        </td>
                        <td>
                            <span class="d-block">{!! toDatetimeInTwoRow($notification->notification_at, $timezone) !!}</span>
                        </td>
                        <td>
                            @if ($notification->recipient->first()->hasBeenReaded())
                                <div class="bg-corporate-color-light p-1 rounded">
                                    <span class="d-block">{!! toDatetimeInTwoRow($notification->recipient->first()->read_at, $timezone) !!}</span>
                                </div>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ( ! $notification->recipient->first()->hasBeenReaded())
                                <a href="{{route('get.notification.mark_read', $notification->recipient->first()->hashId())}}"
                                   title="Mark as read"
                                   class="btn btn-primary btn-xs">
                                    Mark as read
                                </a>
                            @else

                                <a href="{{route('get.notification.mark_read', $notification->recipient->first()->hashId())}}"
                                   title="Mark as read"
                                   class="btn btn-warning btn-xs">
                                    Unmark as read
                                </a>
                            @endif
                        </td>
                    </tr>

                @endforeach

                </tbody>
            </table>

            {{$notifications->appends(request()->except(['_token']))->links()}}
        </div>
    </div>
@endsection
