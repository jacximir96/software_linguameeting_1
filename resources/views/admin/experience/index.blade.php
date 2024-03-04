@extends('layouts.app')

@section('content')


    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-photo-video me-1"></i>
                List of Experiences ({{$timezone->name}})
            </span>
            <a href="{{route('get.admin.experience.create')}}" class="text-success px-4 " title="Create Experience">
                <i class="fa fa-plus"></i> Create Experience
            </a>

        </div>
        <div class="card-body">


            <table id="" class="table table-hover">
                <thead>
                <tr>
                    <th>Recording</th>
                    <th>Title</th>
                    <th>Day</th>
                    <th>Time<br>Start</th>
                    <th>Time<br>End</th>
                    <th>Max.<br>Students</th>
                    <th>Language</th>
                    <th>Level</th>
                    <th>Attendees</th>
                    <th>Public<br>Attendees</th>
                    <th>Donations</th>
                    <th>Comments</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($experiences as $experience)
                    <tr>
                        <td>
                            @if ($experience->hasRecording())
                                <a href="{{$experience->zoom_video}}" target="_blank" title="Show Vídeo">
                                    <i class="fa fa-video"></i>
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <span class="d-block">{{$experience->title}}</span>
                            @if ($experience->course)
                                <a href="{{route('get.admin.course.show', $experience->course->id)}}" class="d-block small text-muted" title="Show Course">
                                    {{$experience->course->name}}
                                </a>

                                <a href="{{route('get.admin.university.show', $experience->course->university->id)}}" class="d-block small text-muted" title="Show University">
                                    {{$experience->course->university->name}}
                                </a>
                            @elseif($experience->university)
                                <a href="{{route('get.admin.university.show', $experience->university->id)}}" class="d-block small text-muted" title="Show University">
                                    {{$experience->university->name}}
                                </a>
                            @endif

                        </td>
                        <td>
                            {{toDate($experience->start)}}
                        </td>
                        <td>
                            {{toTime24h($experience->start, $experienceTimezone->name)}}
                        </td>
                        <td>
                            {{toTime24h($experience->end, $experienceTimezone->name)}}
                        </td>
                        <td>
                            {{$experience->max_students}}
                        </td>
                        <td>
                            {{$experience->language->name}}
                        </td>
                        <td>
                            {{$experience->level->name ?? '-'}}
                        </td>
                        <td>
                            @if ($experience->register_count)

                                <a href="{{route('get.admin.experience.attendees.index', $experience->id)}}"
                                   title="Show Attendees"
                                   class="open-modal small"
                                   data-modal-size="modal-md"
                                   data-modal-reload="no"
                                   data-modal-title='Attendees'>
                                     {{$experience->register_count}} Attendees
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td>

                            @if ($experience->register_public_count)

                                <a href="{{route('get.admin.experience.public_attendees.index', $experience->id)}}"
                                   title="Show Public Attendees"
                                   class="open-modal small"
                                   data-modal-size="modal-md"
                                   data-modal-reload="no"
                                   data-modal-title='Public Attendees'>
                                    {{$experience->register_public_count}} Attendees
                                </a>
                            @else
                                -
                            @endif

                        </td>
                        <td>
                            @if ($experience->donation_count)
                                <a href="{{route('get.admin.experience.donations.index', $experience->id)}}"
                                   title="Show Donations"
                                   class="open-modal small"
                                   data-modal-size="modal-md"
                                   data-modal-reload="no"
                                   data-modal-title='Donations'>
                                    <span class="">{{$linguaMoney->format($experience->sumDonation())}}</span>
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ($experience->comment_count)
                                <a href="{{route('get.admin.experience.comments.index', $experience->id)}}"
                                   title="Show Comments"
                                   class="open-modal small"
                                   data-modal-size="modal-xl"
                                   data-modal-reload="no"
                                   data-modal-title='Comments'>
                                    <i class="fa fa-comments me-1 text-primary"></i>
                                    <span class="">{{$experience->comment_count}}</span>
                                </a>
                            @else
                                <i class="fa fa-comments me-1 text-muted" title="No comments"></i>
                            @endif

                        </td>
                        <td>
                            <a href="{{route('get.admin.experience.edit', $experience->id)}}" class="text-primary me-3" title="Edit Experience">
                                <i class="fa fa-edit"></i>
                            </a>

                            <a href="{{route('get.admin.experience.delete', $experience->id)}}"
                               class="text-danger"
                               onclick="return confirm('Are you sure you want to delete this experience?');"
                               title="Delete Experience">
                                <i class="fas fa-times"></i>
                            </a>
                        </td>
                    </tr>

                @endforeach

                </tbody>
            </table>
            <input type="hidden" name="query-string" id="query-string" class="form-control" value="{{ http_build_query(request()->input()) }}" />
            {{$experiences->appends(request()->except(['_token']))->links()}}
        </div>
    </div>
@endsection
