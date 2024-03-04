@extends('layouts.app')

@section('content')

    <div class="card my-3">
        <div class="card-header p-2 d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <h6 class="m-0 font-weight-bold"><i class="fa fa-search"></i> Search Universities</h6>
        </div>
        <div class="card-body">
            @include('admin.university.search_form')
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header p-2 d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                <span class="">
                    <i class="fas fa-table me-1"></i>
                    List of Universities
                </span>
            <a href="{{route('get.admin.university.create')}}" class="text-success px-4" title="Create University">
                <i class="fa fa-plus"></i> Create University
            </a>

        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-12 mb-3 border-bottom">
                    <a href="{{ route('get.admin.university.excel.download') }}?{{ http_build_query(request()->input()) }}"
                       class="small"
                       title="Download excel with universities">
                        <i class="fa fa-download small-font-size-08"></i> Download Excel
                    </a>
                </div>
            </div>

            <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                <thead>
                <tr>
                    <th>@include('common.link_order', ['path' => 'post.admin.university.search', 'field' => 'name', 'tag' => 'Name'])</th>
                    <th>@include('common.link_order', ['path' => 'post.admin.university.search', 'field' => 'created_at', 'tag' => 'Created on'])</th>
                    <th>Time zone</th>
                    <th>Country</th>
                    <th>¿Lingro?</th>
                    <th>Active<br>courses</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($universities as $university)
                    <tr>
                        <td>
                            <a href="{{route('get.admin.university.show', $university)}}" class="mr-2" title="Show university">
                                {{$university->name}}
                            </a>
                        </td>
                        <td>{{$university->created_at->format('m/d/Y')}}</td>
                        <td>{{$university->timezone->name}}</td>
                        <td>{{$university->country->name}}</td>
                        <td>
                            @php $statusCourses = $university->statusCourses() @endphp

                            @if ($statusCourses->statusLingro()->hasBoth())
                                Both
                            @elseif ($statusCourses->statusLingro()->hasLingro())
                                Yes
                            @else
                                No
                            @endif
                        </td>
                        <td>
                            @if ($statusCourses->numActiveCourses())
                                <a href="{{route('post.admin.course.search', ['from_url' => true, 'university_id' => $university->id, 'status' => 'active'])}}" title="Show active courses">
                                    <span class="badge bg-success">{{$statusCourses->numActiveCourses()}}</span>
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td>

                            @if ($university->trashed())

                                <a href="{{route('get.admin.university.restore', $university->id)}}"
                                   class="text-success"
                                   onclick="return confirm('Are you sure to restore this university?');"
                                   title="Restore University">
                                    <i class="fas fa-recycle"></i>
                                </a>

                            @else

                                <a href="{{route('get.admin.university.edit', $university->id)}}" class="text-primary me-3" title="Edit university">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a href="{{route('get.admin.university.delete', $university->id)}}"
                                   class="text-danger"
                                   onclick="return confirm('Are you sure you want to delete this university?');"
                                   title="Delete University">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$universities->appends(request()->except(['_token']))->links()}}
        </div>
    </div>
@endsection
