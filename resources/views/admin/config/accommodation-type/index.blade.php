@extends('layouts.app')

@section('content')

    <div class="row">

        <div class="col-12 col-xl-6">

            <div class="card mb-4">

                <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                    <span class="">
                        <i class="fas fa-low-vision me-1"></i>
                        Accommodation Types
                    </span>

                    <a href="{{route('get.admin.config.accommodation_type.create')}}"
                       title="Create Accommodation Type"
                       class="open-modal mt-1 text-success "
                       data-modal-size="modal-lg"
                       data-modal-reload="yes"
                       data-reload-type="parent"
                       data-modal-title="Create Accommodation Type">
                        <i class="fa fa-plus"></i> Create Type
                    </a>
                </div>

                <div class="card-body ">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                                <thead>
                                <tr class="small">
                                    <th class="w-50">
                                        Description
                                    </th>
                                    <th class="w-20">
                                        Individual Session
                                    </th>
                                    <th class="w-10">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($types as $type)

                                    <tr>
                                        <td>{{$type->description ?? '-'}}</td>
                                        <td>{{$type->hasIndividualSession() ? 'Yes' : '-'}}</td>
                                        <td>
                                            <a href="{{route('get.admin.config.accommodation_type.edit', $type->hashId())}}"
                                               class="open-modal me-3"
                                               data-modal-size="modal-md"
                                               data-modal-reload="yes"
                                               data-reload-type="parent"
                                               data-modal-title='Edit Type'
                                               title="Edit Type">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a href="{{route('get.admin.config.accommodation_type.delete', $type->hashId())}}"
                                               onclick="return confirm('Are you sure you want to delete this accommodation type?');"
                                               title="Delete Type ">
                                                <i class="fa fa-times text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
