@extends('layouts.app')

@section('content')

    @if (isset($newCodeGenerated))

        <div class="row">
            <div class="col-12 ">
                <div class="alert alert-success">
                    <span class="d-inline-block mb-2">Code generated sucessfully.</span>
                    <span class="d-block mt-4 fw-bold h6">{{$newCodeGenerated}}</span>
                </div>
            </div>
        </div>

    @endif


    <div class="card my-3">
        <div class="card-header d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <h6 class="m-0 font-weight-bold"><i class="fa fa-search"></i> Search Codes</h6>
        </div>
        <div class="card-body">
            @include('admin.register-code.search_form')
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                <span class="">
                    <i class="fas fa-barcode me-1"></i>
                    List of Codes
                </span>

            <a href="{{route('get.admin.register_code.code.create')}}"
               class="text-success px-4"
               onclick="return confirm('Are you sure to create new code?');"
               title="Create Code">
                <i class="fa fa-plus"></i> Create Code
            </a>
        </div>
        <div class="card-body">


            <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Used</th>
                    <th>Student</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($codes as $code)
                    <tr>
                        <td>{{$code->id}}</td>
                        <td>
                            {{$code->code}}
                        </td>
                        <td>
                            @if ($code->isUsed())
                                <span class="badge bg-success">Yes</span>
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            Student name
                        </td>
                        <td>
                            2023-12-12
                        </td>

                        <td>

                            <a href="{{route('get.admin.student.extra_session.change_status', $code->id)}}"
                               onclick="return confirm('Are you sure to change status this code?');"
                               class="{{$code->isUsed() ? 'text-success' : 'text-warning'}} me-3"
                               title="{{$code->isUsed() ? 'Change status to not used' : 'Change status to used'}}">
                                <i class="fa fa-exchange-alt"></i>
                            </a>

                            @if ( ! $code->isUsed())
                                <a href="{{route('get.admin.register_code.code.delete', $code->id)}}"
                                   onclick="return confirm('Are you sure you want to delete this code?');"
                                   class="text-danger"
                                   title="Delete code">
                                    <i class="fa fa-times"></i>
                                </a>
                            @endif
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td class="text-left" colspan="10">
                            <span class="bg-warning p-2 py-1 rounded text-white">Codes not found</span>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{$codes->appends(request()->except(['_token']))->links()}}
        </div>
    </div>
@endsection
