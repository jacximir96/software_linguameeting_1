@extends('layouts.app')

@section('content')


    <div class="card my-3">
        <div class="card-header p-2 d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <h6 class="m-0 font-weight-bold"><i class="fa fa-search"></i> Search Courses</h6>
        </div>
        <div class="card-body">
            @include('admin.course.search_form')
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header p-2 d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                <span class="">
                    <i class="fas fa-table me-1"></i>
                    List of courses ({{$courses->total()}})

                    @php($currentStatus = $searchForm->status())
                    @if ($currentStatus->isActive())
                        <span class="badge bg-success">Active</span>
                    @elseif($currentStatus->isDraft())
                        <span class="badge bg-secondary">Draft</span>
                    @else
                        <span class="badge bg-warning">Past</span>
                    @endif
                </span>
            <a href="{{route('get.admin.course.coaching_form.create.zero_step')}}" class="text-success px-4 " title="Create Course">
                <i class="fa fa-plus"></i> Create Course
            </a>

        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-12 mb-3 border-bottom">
                    <a href="{{ route('get.admin.course.excel.download') }}?{{ http_build_query(request()->input()) }}"
                       class="small"
                       title="Download excel with selected courses">
                        <i class="fa fa-download small-font-size-08"></i> Download Excel
                    </a>
                </div>
            </div>

            <table id="datatablesSimple" class="table table-hover small" data-paging="false" data-searching="false" data-ordering="false">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>@include('common.link_order', ['path' => 'post.admin.course.search', 'field' => 'university', 'tag' => 'University'])</th>
                    <th>@include('common.link_order', ['path' => 'post.admin.course.search', 'field' => 'name', 'tag' => 'Name'])</th>
                    <th>Service</th>
                    <th>Lingro</th>
                    <th>Period</th>
                    <th>Year</th>
                    <th>@include('common.link_order', ['path' => 'post.admin.course.search', 'field' => 'start_date', 'tag' => 'Start Date'])</th>
                    <th>@include('common.link_order', ['path' => 'post.admin.course.search', 'field' => 'end_date', 'tag' => 'End Date'])</th>
                    <th>Registered</th>
                    <th>X Session</th>
                    <th>@include('common.link_order', ['path' => 'post.admin.course.search', 'field' => 'created_at', 'tag' => 'Created'])</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($courses as $course)

                    <tr>
                        <td>{{$course->id}}</td>
                        <td>{{$course->university->name}}</td>
                        <td>
                            <a href="{{route('get.admin.course.show', $course->id)}}" title="Show course">
                                {{$course->name}} {{$course->isFlex()?'(Flex)':''}}
                            </a>
                        </td>
                        <td>{{$course->serviceType->name_short}}</td>
                        <td>{{ $course->isLingro() ? 'Yes' : 'No' }}</td>
                        <td>{{$course->semester->name}}</td>
                        <td class="text-left">{{$course->year}}</td>
                        <td class="text-left">{{$course->start_date->toFormattedDayDateString()}}</td>
                        <td class="text-left">{{$course->end_date->toFormattedDayDateString()}}</td>

                        <td>{{$course->enrollment_count}}/{{$course->section()->sum('num_students')}}</td>
                        <td>{{$course->student_class}}</td>
                        <td>{{toFormattedDayDateString($course->created_at, $timezone)}}</td>

                        <td>
                            <a href="{{$course->editUrl()->get()}}" title="Edit coaching form">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="12">
                            <span class="bg-warning px-2">Courses not found</span>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{$courses->appends(request()->except(['_token']))->links()}}
        </div>
    </div>
@endsection
