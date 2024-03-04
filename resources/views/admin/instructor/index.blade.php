@extends('layouts.app')

@section('content')


    <div class="card my-3">
        <div class="card-header d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <h6 class="m-0 font-weight-bold"><i class="fa fa-search"></i> Search Instructors</h6>
        </div>
        <div class="card-body">
            @include('admin.instructor.search_form')
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                <span class="">
                    <i class="fas fa-table me-1"></i>
                    List of Instructors
                </span>
            <a href="{{route('get.admin.instructor.create')}}" class="text-success px-4" title="Create Instructor">
                <i class="fa fa-plus"></i> Create Instructor
            </a>

        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-12 mb-3 border-bottom">
                    <a href="{{ route('get.admin.instructor.excel.download') }}?{{ http_build_query(request()->input()) }}"
                       class="small"
                        title="Download excel with selected instructors">
                        <i class="fa fa-download small-font-size-08"></i> Download Excel
                    </a>
                </div>
            </div>

            <table id="" class="table table-hover">
                <thead>
                <tr>
                    <td class="">

                    </td>
                    <th>ID</th>
                    <th>@include('common.link_order', ['path' => 'post.admin.instructor.search', 'field' => 'lastname', 'tag' => 'Last Name'])</th>
                    <th>@include('common.link_order', ['path' => 'post.admin.instructor.search', 'field' => 'name', 'tag' => 'Name'])</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>University</th>
                    @if ($searchTeachignAssistant)
                        <th>Instructor<br>assigned</th>
                    @endif
                    <th>¿Lingro?</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($instructors as $instructor)
                    <tr>
                        <td>
                            {{Form::checkbox('selected_id[]', $instructor->id,null, ['class' => 'item-to-select'] )}}
                        </td>
                        <td>{{$instructor->id}}</td>
                        <td>
                            <a href="{{route('get.admin.instructor.show', $instructor->hashId())}}" class="mr-2" title="Show instructor">
                                {{$instructor->lastname}}
                            </a>
                        </td>
                        <td>
                            <a href="{{route('get.admin.instructor.show', $instructor->hashId())}}" class="mr-2" title="Show instructor">
                                {{$instructor->name}}
                            </a>

                            @if ( ! $instructor->isActive())
                                <span class="badge bg-warning text-dark ms-2">Disabled</span>
                            @endif

                            @if ( $instructor->isDeleted()!='')
                                <span class="badge bg-danger text-dark ms-2">Deleted</span>
                            @endif

                            @if ($instructor->isLocked())
                                <span class="badge bg-warning text-dark ms-2" title="{{$instructor->minutesToEndLock()}} minutes to auto unlock">
                                    Blocked ({{$instructor->minutesToEndLock()}})
                                </span>
                            @endif
                        </td>

                        <td>
                            <span class="{{$colorFactory->classColorByInstructorRol($instructor->roles->first())}} {{$instructor->isExactlyInstructor() ? '' : 'fw-bold'}}">
                                {{$instructor->getRoleName()->first()}}
                            </span>
                        </td>
                        <td>{{$instructor->email}}</td>
                        <td>{{$instructor->university->first()->name ?? ''}}</td>
                        @if ($searchTeachignAssistant)
                            <td>
                                @if ($instructor->instructedBy->count())
                                    <a href="{{route('get.admin.instructor.show', $instructor->instructedBy->first()->instructor_id)}}"
                                       class="text-primary me-3" title="Show instructor">
                                        {{$instructor->instructedBy->first()->instructor->writeFullName()}}
                                    </a>
                                    <a  href="{{route('get.admin.instructor.teaching_assistant.assign_instructor.delete', $instructor->instructedBy->first()->hashId())}}"
                                        onclick="return confirm('Are you sure to remove this assignment?');"
                                        title="Remove relationship ">
                                        <i class="fa fa-times text-danger"></i>
                                    </a>


                                @else
                                    <a  href="{{route('get.admin.instructor.teaching_assistant.assign_instructor', $instructor->hashId())}}"
                                        title="Assign instructor to {{$instructor->writeFullName()}}"
                                        class="open-modal"

                                        data-modal-reload="yes"
                                        data-reload-type="parent"
                                        data-modal-title='Assign instrutor to assistant'>
                                        <i class="fa fa-plus text-success"></i> Assign
                                    </a>

                                @endif
                            </td>
                        @endif
                        <td>{{$instructor->hasLingroCourse() ? 'Yes' : '-'}}</td>
                        <td>

                            @if ($instructor->trashed())
                                <a href="{{route('get.admin.user.restore', $instructor->hashId())}}"
                                   class="text-success"
                                   onclick="return confirm('Are you sure to restore this instructor?');"
                                   title="Recover Instructor">
                                    <i class="fas fa-undo"></i>
                                </a>
                            @else

                                <a  href="{{route('get.impersonate.start', $instructor->hashId())}}"
                                    class="me-3"
                                    title="Access as {{$instructor->name}}">
                                    <i class="fa fa-user-friends"></i>
                                </a>

                                <a href="{{route('get.admin.instructor.edit', $instructor->hashId())}}" class="text-primary me-3" title="Edit instructor">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a href="{{route('get.admin.instructor.delete', $instructor->hashId())}}"
                                   class="open-modal text-danger"
                                   data-modal-reload="yes"
                                   data-reload-type="parent"
                                   data-modal-title='Delete Instructor'
                                   title="Delete Instructor">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-left" colspan="10">
                            <span class="bg-warning p-2 py-1 rounded text-white">Instructors not found</span>
                        </td>
                    </tr>
                @endforelse

                <tr>

                    <td colspan="10" class="">
                        <input type="checkbox" name="check_all" class="check-and-uncheck-all-with-all" data-target-class="item-to-select"/>

                        <p class="ms-3 p-2 rounded bg-light d-none d-inline" id="block-all">
                            <span class="d-inline-block me-3 text-muted">Están seleccionados los {{$instructors->count()}} instructores de esta página.</span>
                            <span class="d-inline-block text-primary">
                                ¿Seleccionar los {{$instructors->total()}} instructores del listado completo? <input type="checkbox" id="select-all" name="select_all" value="all" />
                            </span>
                        </p>
                    </td>
                </tr>
                <tr>

                    <td colspan="10">

                        <a href="{{route('get.admin.instructor.email.send.config_view')}}"
                           title="Send mail to selected instructors"
                           data-target-class="item-to-select"


                           data-modal-reload="yes"
                           data-reload-type="parent"
                           data-modal-title='Send email'

                           class="send-mail-selected-users">
                            <i class="fa fa-envelope"></i> Send mail
                        </a>
                    </td>
                </tr>

                </tbody>
            </table>
            <input type="hidden" name="query-string" id="query-string" class="form-control" value="{{ http_build_query(request()->input()) }}" />
            {{$instructors->appends(request()->except(['_token']))->links()}}
        </div>
    </div>
@endsection
