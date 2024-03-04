<div class="card mb-4">
    <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                <span class="">
                    <i class="fas fa-university me-1"></i>
                    University details
                </span>
    </div>
    <div class="card-body">

        <div class="row gx-3 mb-1">
            <div class="col-md-9 mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <label class="me-3 fw-bold text-corporate-color" for="">Name</label>
                    </div>
                    <div class="col-md-9">
                        <span class="fw-bold">{{$viewData->university()->name}}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gx-3 mb-1">
            <div class="col-md-9 mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <label class="me-3 fw-bold text-corporate-color" for="">Country</label>
                    </div>
                    <div class="col-md-9">
                        <span class="">{{$viewData->university()->country->name}}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gx-3 mb-1">
            <div class="col-md-9 mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <label class="me-3 fw-bold text-corporate-color" for="">Timezone</label>
                    </div>
                    <div class="col-md-9">
                        <span class="">{{$viewData->university()->timezone->description}}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gx-3 mb-1">
            <div class="col-md-9 mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <label class="me-3 fw-bold text-corporate-color" for="">Level</label>
                    </div>
                    <div class="col-md-9">
                        <span class="">{{$viewData->university()->level->name}}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gx-3 mb-0">
            <div class="col-md-9 mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <label class="me-3 fw-bold text-corporate-color" for="">Status</label>
                    </div>
                    <div class="col-md-9">
                        @if ($viewData->university()->isActive())
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Disabled</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row gx-3 mb-1">
            <div class="col-md-9 mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <label class="me-3 fw-bold text-corporate-color" for="">Comment</label>
                    </div>
                    <div class="col-md-9 border-1">
                        {{$viewData->university()->hasInternalComment() ? $viewData->university()->internal_comment : '-'}}
                    </div>
                </div>
            </div>
        </div>

        <div class="row gx-3 mb-3">
            <div class="col-md-6">
                <label class="small mb-1 d-block fw-bold "></label>
                <a href="{{route('get.admin.university.edit', $viewData->university()->id)}}" class="text-primary"><i class="fa fa-edit"></i> Edit</a>
            </div>
        </div>
    </div>
</div>
