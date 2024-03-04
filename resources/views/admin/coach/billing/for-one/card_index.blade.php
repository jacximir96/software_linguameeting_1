@extends('layouts.app')

@section('content')

    @include('user.row_status', ['user' => $coach])

    <div class="row my-3">
        <div class="col-12">

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                <span class="">
                    <i class="fas fa-dollar-sign me-1"></i>
                    Coach Billing Configuration
                </span>
                </div>
                <div class="card-body">

                    <div class="row mb-2">
                        <div class="col-12">
                            <p class="border-bottom">
                                <span class="fw-bold">Coach</span>
                                <a href="{{route('get.admin.coach.show', $coach->hashId())}}" class="ms-2">{{$coach->writeFullName()}}</a>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 border-bottom">
                            <span class="text-corporate-color fw-bold me-5"><i class="fa fa-file-invoice-dollar"></i> Salary</span>
                        </div>
                        <div class="col-12 col-xl-4 ">

                            <div class="row">
                                @if ($coach->salary)
                                    <div class="col-12 mt-3">
                                        <span class="fw-bold d-inline-block me-5">Type</span>
                                        <span class="d-inline-block text-decoration-underline">{{$coach->salary->type->name}}</span>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <span class="fw-bold d-inline-block me-5">Value</span>
                                        <span class="d-inline-block text-decoration-underline">{{$linguaMoney->format($coach->salary->value)}}</span>
                                    </div>
                                @else
                                    <div class="col-12 mt-3">
                                        <span class="fw-bold d-inline-block me-5">Type</span>
                                        <span class="d-inline-block text-decoration-underline">El coach no tiene un salario configurado</span>
                                    </div>
                                @endif

                                <div class="col-12 mt-3">
                                    <span class="fw-bold d-inline-block me-5">Payer Coach</span>
                                    @if ($coach->coachInfo->isPayer())
                                        <span class="d-inline-block text-decoration-underline">Yes</span>
                                    @else
                                        -
                                    @endif
                                </div>

                                @if ($coach->salary)
                                    <div class="col-12 mt-3">
                                        <span class="fw-bold d-inline-block me-5">Additional salary from<br> all your coaches</span>

                                        @if($coach->salary->hasExtraCoordinator())
                                            <span class="d-inline-block text-decoration-underline">
                                            {{$linguaMoney->format($coach->salary->extra_coordinator)}}
                                        </span>
                                        @else
                                            No
                                        @endif

                                    </div>
                                @endif

                                <div class="col-12 mt-4">
                                    @if ($coach->salary)
                                        <a href="{{route('get.admin.coach.billing.salary.edit', $coach->salary->hashId())}}"
                                           class="open-modal btn btn-xs btn-primary me-2"
                                           data-modal-reload="yes"
                                           data-modal-size="modal-lg"
                                           data-reload-type="parent"
                                           title="Edit Salary">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    @else
                                        <a href="{{route('get.admin.coach.billing.salary.create', $coach->hashId())}}"
                                           class="open-modal btn btn-xs btn-success me-2"
                                           data-modal-reload="yes"
                                           data-modal-size="modal-lg"
                                           data-reload-type="parent"
                                           title="Create Salary">
                                            <i class="fa fa-edit"></i> Create
                                        </a>
                                    @endif

                                    <a href="{{route('get.admin.coach.billing.for_one.filter', $coach->hashId())}}"
                                       class="open-modal btn btn-xs btn-primary me-2"
                                       data-modal-reload="no"
                                       data-modal-size="modal-lg"
                                       data-modal-title="Show Billing"
                                       title="Show Billing">
                                        <i class="fa fa-dollar-sign"></i> Show Billing
                                    </a>

                                    <a href="{{route('get.admin.coach.billing.invoice.coach_list', $coach->hashId())}}"
                                       class="open-modal btn btn-xs btn-primary"
                                       data-modal-reload="no"
                                       data-modal-size="modal-lg"
                                       data-modal-title="Coach Invoices"
                                       title="Coach Invoices">
                                        <i class="fa fa-file-invoice-dollar"></i> Invoices
                                    </a>


                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="col-12 mt-3">
                                <span class="fw-bold d-inline-block me-5">Comments</span>
                                <div class="small">{!! $coach->salary->comments ?? '-' !!}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12 col-xl-5">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between border-bottom ">
                                    <span class="fw-bold p-2 text-success"><i class="fa fa-arrow-up"></i> Incentives</span>

                                    <a href="{{route('get.admin.coach.billing.incentive.create', $coach->hashId())}}"

                                       title="Create Incentive"
                                       class="open-modal text-success"
                                       data-modal-size="modal-md"
                                       data-modal-reload="yes"
                                       data-reload-type="parent"
                                       data-modal-title='Create Incentive'>
                                        <i class="fa fa-plus"></i> Create
                                    </a>
                                </div>

                                @include('admin.coach.billing.incentive.table')
                            </div>
                        </div>
                        <div class="col-12 col-xl-5 offset-xl-1">
                            <div class="row">
                                <div class="col-12 text-danger border-bottom d-flex justify-content-between">
                                    <span class="fw-bold h6 p-2"><i class="fa fa-arrow-down"></i> Discounts</span>

                                    <a href="{{route('get.admin.coach.billing.discount.create', $coach->hashId())}}"

                                       title="Create Discount"
                                       class="open-modal text-success"
                                       data-modal-size="modal-md"
                                       data-modal-reload="yes"
                                       data-reload-type="parent"
                                       data-modal-title='Create Discount'>
                                        <i class="fa fa-plus"></i> Create
                                    </a>
                                </div>

                                @include('admin.coach.billing.discount.table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
