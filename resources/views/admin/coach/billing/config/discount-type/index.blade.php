@extends('layouts.app')

@section('content')

    <div class="row">

        <div class="col-12 col-xl-6">

            <div class="card mb-4">

                <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                    <span class="">
                        <i class="fas fa-cog me-1"></i>
                        Discount Types
                    </span>

                    <a href="{{route('get.admin.coach.billing.config.discount.options.create')}}"
                       title="Create Discount Type"
                       class="open-modal mt-1 text-success "
                       data-modal-size="modal-lg"
                       data-modal-reload="yes"
                       data-reload-type="parent"
                       data-modal-title="Create Discount Type">
                        <i class="fa fa-plus"></i> Create Type
                    </a>
                </div>

                <div class="card-body ">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                                <thead>
                                <tr class="small">
                                    <th class="w-30">
                                        Name
                                    </th>
                                    <th class="w-60">
                                        Description
                                    </th>
                                    <th class="w-10">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($types as $type)

                                    <tr>
                                        <td>{{$type->name}}</td>
                                        <td>{{$type->description ?? '-'}}</td>
                                        <td>
                                            <a href="{{route('get.admin.coach.billing.config.discount.options.edit', $type->hashId())}}"
                                               class="open-modal me-3"
                                               data-modal-size="modal-md"
                                               data-modal-reload="yes"
                                               data-reload-type="parent"
                                               data-modal-title='Edit Type'
                                               title="Edit Type">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a href="{{route('get.admin.coach.billing.config.discount.options.delete', $type->hashId())}}"
                                               onclick="return confirm('Are you sure you want to delete this discount type?');"
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
