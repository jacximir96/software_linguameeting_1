@php
use Lab404\Impersonate\Services\ImpersonateManager;$impersonate = app(ImpersonateManager::class);
@endphp

<div class="row mt-2 gx-0 ">
    <div class="col-12 alert alert-danger bg-corporate-danger shadow-sm rounded d-sm-flex justify-content-sm-between">
        <span class="d-block text-white">
            <span class="fw-bold">{{user()->getRoleName()->first()}} simulation:</span>
            <span class="fst-italic">{{user()->writeFullName()}}</span>
        </span>

        <a href="{{route('get.impersonate.leave')}}"
           title="Go out simulation"
           class="d-inline-block mt-2 mt-sm-0">
            <i class="fa fa-sign-out-alt"></i> Go out
        </a>
    </div>
</div>
