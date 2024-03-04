@extends('layouts.app')

@section('content')

    @if(isset($newRequest) AND $newRequest->exists)

        <div class="row">
            <div class="col-12 ">
                <div class="alert alert-primary">
                    <span class="d-block mb-2">Now, you can download new file codes:</span>
                    <a href="{{route('get.admin.register_code.bookstore_request.download.pdf', $newRequest->id)}}" class="btn btn-primary btn-sm">Download PDF</a>

                    <a href="{{route('get.admin.register_code.bookstore_request.download.excel', $newRequest->id)}}" class="btn btn-primary btn-sm ms-5">Download EXCEL</a>
                </div>
            </div>
        </div>

    @endif

    @include('admin.university.bookstore.shared.search_form')

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-table me-1"></i>
                List of requests
            </span>

            <div>
                @include('admin.university.bookstore.shared.create_links')
            </div>
        </div>
        <div class="card-body">
            <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>University</th>
                    <th>Course type</th>
                    <th>Total Codes</th>
                    <th>Date</th>
                    <th>File</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($requests as $request)

                    <tr>
                        <td>{{$request->id}}</td>
                        <td>{{$request->university->name}}</td>
                        <td>{{$request->conversationPackage->name}}</td>
                        <th class="">{{$request->num_codes}}</th>
                        <td class="">
                            {{toDate($request->date_request)}}
                        </td>
                        <td>

                            <a href="{{route('get.admin.register_code.bookstore_request.download.pdf', $request->id)}}"
                               title="Download PDF">
                                <i class="fa fa-file-pdf"></i>
                            </a>

                            <a href="{{route('get.admin.register_code.bookstore_request.download.excel', $request->id)}}"
                               class="ms-3"
                               title="Download EXCEL">
                                <i class="fa fa-file-excel"></i>
                            </a>

                        </td>
                        <td>
                            <a href="{{route('get.admin.register_code.bookstore_request.show', $request)}}" class="text-success me-2" title="Show request">
                                <i class="fa fa-eye"></i>
                            </a>

                            <a href="{{route('get.admin.register_code.bookstore_request.delete', $request)}}"
                               onclick="return confirm('Are you sure to remove this request?');"
                               class="text-danger"
                               title="Delete request">
                                <i class="fa fa-times"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$requests->appends(request()->except(['_token']))->links()}}
        </div>
    </div>
@endsection
