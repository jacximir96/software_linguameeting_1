@extends('layouts.app')

@section('content')


    <div class="card mb-4 col-12">
        <div class="card-header p-2 d-flex justify-content-between  bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-book me-1"></i>
                List of conversation guides
            </span>

            <a href="{{route('get.admin.config.conversation_package.create')}}" class="text-success px-4" title="Create Package">
                <i class="fa fa-plus"></i> Create Package
            </a>
        </div>
        <div class="card-body">

            <table id="" class="table table-hover small">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Sessions</th>
                    <th>Duration</th>
                    <th>Isbn</th>
                    <th>Price</th>
                    <th>Experiences</th>
                    <th>Active</th>
                    <th>Comments</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                @php $typeId = $packages->first()->guide_origin_id @endphp

                @foreach ($packages as $package)
                    @if ($typeId != $package->session_type_id)
                        <tr class="bg-corporate-color-light">
                            <td colspan="11">
                                <span class="fw-bold"><i class="fa fa-tag text-corporate-dark-color me-2"></i> {{$package->sessionType->name}}</span>
                            </td>
                        </tr>
                        @php $typeId = $package->session_type_id @endphp
                    @endif
                    <tr>
                        <td>{{$package->id}}</td>
                        <td>
                            {{$package->sessionType->name}}
                        </td>
                        <td>
                             <span class="{{!$package->code_active ? 'text-danger' : ''}}">
                                {{$package->name}}
                             </span>
                        </td>
                        <td>{{$package->number_session}}</td>
                        <td>{{$package->duration_session}}</td>
                        <td>{{$package->isbn}}</td>
                        <td>{{format_money($package->price)}}</td>
                        <td class="{{$package->experiences ? 'fw-bold' : ''}}">{{$package->experiences ? 'Yes' : 'No'}}</td>
                        <td>
                            @if ($package->code_active)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-danger ">No</span>
                            @endif
                        </td>
                        <td class="w-25">
                            {{$package->comments ?? ''}}
                        </td>

                        <td>
                            <a href="{{route('get.admin.config.conversation_package.edit', $package->id)}}"
                               class="me-2"
                               title="Edit conversation package">
                                <i class="fa fa-edit"></i>
                            </a>

                            <a href="{{route('get.admin.config.conversation_package.delete', $package->id)}}"
                               class="btna btn-xsa btn-primarya text-danger"
                               onclick="return confirm('Are you sure you want to delete this conversation package?');"
                               title="Delete conversation package">
                                <i class="fa fa-times me"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
