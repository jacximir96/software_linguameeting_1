@extends('layouts.app')

@section('content')


    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                <span class="">
                    <i class="fas fa-file-invoice me-1"></i>
                    Bookstore request details
                </span>
                </div>
                <div class="card-body">

                    <div class="row gx-3 mb-3">

                        <div class="col-md-4 mb-3">
                            <label class="small mb-1 fw-bold" for="">University</label>
                            <input class="form-control" type="text" value="{{$request->university->name}}" disabled>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="small mb-1 fw-bold" for="">Course type</label>
                            <input class="form-control" type="text" value="{{$request->conversationPackage->name}}" disabled>
                        </div>
                    </div>

                    <div class="row gx-3 mb-3">
                        <div class="col-md-2 mb-3">
                            <label class="small mb-1 d-block fw-bold">Requested codes</label>
                            <span class="badge bg-primary">{{$request->num_codes}}</span>
                        </div>

                        <div class="col-md-2 mb-3">
                            <label class="small mb-1 d-block fw-bold">Used codes</label>
                            <span class="badge bg-success">{{$numUsedCodes}}</span>
                        </div>

                        <div class="col-md-2 mb-3">
                            <label class="small mb-1 d-block fw-bold">Deleted codes</label>
                            <span class="badge bg-danger">{{$numDeletedCodes}}</span>
                        </div>
                    </div>

                    <div class="row gx-3 mb-3">

                        <div class="col-md-3">
                            <label class="small mb-1 fw-bold" for="date">Date</label>
                            <input class="form-control" type="text" name="date" value="{{$request->date_request->format('d-m-Y')}}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="small mb-1 fw-bold d-block" for="inputLastName">File</label>


                            <a  href="{{route('get.admin.register_code.bookstore_request.download.pdf', $request->id)}}"
                                class=""
                                title="Download PDF">
                                <i class="fa fa-download"></i> Download PDF
                            </a>

                            <a  href="{{route('get.admin.register_code.bookstore_request.download.excel', $request->id)}}"
                                class="ms-5"
                                title="Download Excel">
                                <i class="fa fa-download"></i> Download EXCEL
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                <span class="">
                    <i class="fas fa-barcode me-1"></i>
                    Request codes
                </span>
                </div>
                <div class="card-body">
                    @include('admin.university.bookstore.code.table_codes', ['codes' => $codes])
                </div>
            </div>
        </div>
    </div>


@endsection
