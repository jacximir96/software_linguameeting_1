<div class="row">
    <div class="col-md-4">

        <div class="card mb-4">
            <div class="card-header d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                <h6 class="m-0 font-weight-bold"><i class="fa fa-search"></i> Search Request</h6>
            </div>
            <div class="card-body">
                @include('admin.university.bookstore.request.search_form', ['searchForm' => $searchFormRequest])
            </div>
        </div>
    </div>

    <div class="col-md-6 offset-md-1">

        <div class="card mb-4">
            <div class="card-header d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                <h6 class="m-0 font-weight-bold"><i class="fa fa-search"></i> Search Code</h6>
            </div>
            <div class="card-body">
                @include('admin.university.bookstore.code.search_form', ['searchForm' => $searchFormCode])
            </div>
        </div>

    </div>

</div>
