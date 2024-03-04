@extends('layouts.app')

@section('content')


    <div class="card my-3">
        <div class="card-header d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <h6 class="m-0 font-weight-bold"><i class="fa fa-search"></i> Search Students</h6>
        </div>
        <div class="card-body">
            @include('admin.student.search_form')
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                <span class="">
                    <i class="fas fa-table me-1"></i>
                    List of Students
                </span>
            <a href="{{route('get.admin.student.create')}}" class="text-success px-4" title="Create Student">
                <i class="fa fa-plus"></i> Create Student
            </a>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-12 mb-3 border-bottom">
                    <a href="{{ route('get.admin.student.excel.download') }}?{{ http_build_query(request()->input()) }}"
                       class="small"
                       title="Download excel with selected students">
                        <i class="fa fa-download small-font-size-08"></i> Download Excel
                    </a>
                </div>
            </div>

            <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                <thead>
                <tr>
                    <td class="">

                    </td>
                    <th>ID</th>
                    <th>@include('common.link_order', ['path' => 'post.admin.student.search', 'field' => 'name', 'tag' => 'Name'])</th>
                    <th>@include('common.link_order', ['path' => 'post.admin.student.search', 'field' => 'lastname', 'tag' => 'Last Name'])</th>
                    <th>Email</th>
                    <th>University</th>
                    <th>Course</th>
                    <th>Register</th>
                    <th>Lingro</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($students as $student)
                    <tr>
                        <td>
                            {{Form::checkbox('selected_id[]', $student->id,null, ['class' => 'item-to-select'] )}}
                        </td>
                        <td>{{$student->id}}</td>
                        <td>
                            <a href="{{route('get.admin.student.show', $student->hashId())}}" class="mr-2" title="Show student">
                                {{$student->name}}
                            </a>
                        </td>
                        <td>
                            <a href="{{route('get.admin.student.show', $student->hashId())}}" class="mr-2" title="Show student">
                                {{$student->lastname}}
                            </a>

                            @if ( ! $student->isActive())
                                <span class="badge bg-warning text-dark ms-2">Disabled</span>
                            @endif

                            @if ( $student->isDeleted()!='')
                                <span class="badge bg-danger text-dark ms-2">Deleted</span>
                            @endif
                        </td>

                        <td>{{$student->email}}</td>
                        <td>
                            @if ($student->enrollment->count())
                                <a  href="{{route('get.admin.university.show', $student->enrollment->first()->section->course->university_id)}}"
                                    title="Show university">
                                    {{ $student->enrollment->first()->section->course->university->name }}
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ($student->enrollment->count())
                                <a  href="{{route('get.admin.course.show', $student->enrollment->first()->section->course_id)}}"
                                    title="Show course">
                                    {{ $student->enrollment->first()->section->course->name }}
                                </a>

                                @include('admin.student.accommodation.link', ['enrollment' => $student->enrollment->first()])
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ($student->enrollment->count())
                                <span class="d-block">
                                    {{ $student->enrollment->first()->status_at->format('m/d/Y') }}
                                </span>
                                <span class="d-block">
                                    {{ $student->enrollment->first()->status_at->format('H:i:s') }}
                                </span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-left">
                           @if ($student->enrollment->count())
                               @if ($student->enrollment->first()->section->course->isLingro())
                                   Yes
                               @else
                                   No
                               @endif
                           @else
                            -
                            @endif
                        </td>
                        <td>

                            <a href="{{route('get.admin.student.edit', $student->hashId())}}" class="text-primary me-2" title="Edit student">
                                <i class="fa fa-edit"></i>
                            </a>

                            @if ($student->trashed())
                                <a href="{{route('get.admin.student.restore', $student->hashId())}}"
                                   class="text-success"
                                   onclick="return confirm('Are you sure to restore this student?');"
                                   title="Delete Student">
                                    <i class="fas fa-undo"></i>
                                </a>
                            @else
                                <a href="{{route('get.admin.student.delete', $student->hashId())}}"
                                   onclick="return confirm('Are you sure to remove {{$student->writeFullName()}}?');"
                                   class="text-danger"
                                   title="Delete student">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif



                        </td>
                    </tr>

                @empty
                    <tr>
                        <td class="text-left" colspan="10">
                            <span class="bg-warning p-2 py-1 rounded text-white">Students not found</span>
                        </td>
                    </tr>
                @endforelse

                    <tr>

                        <td colspan="10" class="">
                            <input type="checkbox" name="check_all" class="check-and-uncheck-all-with-all" data-target-class="item-to-select"/>

                            <p class="ms-3 p-2 rounded bg-light d-none d-inline" id="block-all">
                                <span class="d-inline-block me-3 text-muted">Están seleccionados los {{$students->count()}} estudiantes de esta página.</span>
                                <span class="d-inline-block text-primary">
                                ¿Seleccionar los {{$students->total()}} estudiantes del listado completo? <input type="checkbox" id="select-all" name="select_all" value="all" />
                            </span>
                            </p>
                        </td>
                    </tr>
                    <tr>

                        <td colspan="10">

                            <a href="{{route('get.admin.student.email.send.config_view')}}"
                               title="Send mail to selected students"
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
            {{$students->appends(request()->except(['_token']))->links()}}
        </div>
    </div>
@endsection
