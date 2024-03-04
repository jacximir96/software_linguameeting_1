<div class="card">
    <div class="card-header p-2 d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
        <h6 class="m-0 font-weight-bold"><i class="fa fa-search"></i> Search Periods</h6>
    </div>
    <div class="card-body">
        @if ($viewData->searchForm()->hasPeriodsOptions())
            @include('admin.course.schedule.search_form', ['searchForm' => $viewData->searchForm()])
        @else
            <p>
                <span class="text-danger">El curso no tiene configuradas coaching weeks!</span>
            </p>
        @endif
    </div>
</div>
