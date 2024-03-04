<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('common.head')
</head>
<body class="sb-nav-fixed">

<nav class="sb-topnav navbar navbar-expand shadow  bg-text-corporate-color text-white">
    @include('common.topnav')
</nav>

<div id="layoutSidenav">

    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-light shadow" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                @if (user()->isCoach())
                    @include('common.sidebar_coach')
                @elseif (user()->isStudent())
                    @include('common.sidebar_student')
                @elseif (user()->isInstructor())
                    @include('common.sidebar_instructor')
                @else

                    @include('common.sidebar')
                @endif
            </div>
            <div class="sb-sidenav-footer small">
                <div class="small">Logged in as:</div>
                <span class="d-block">{{ Auth::user()->name }}</span>
                <span class="d-block">{{ obtainTimezoneName($timezone ?? null) }}</span>
                <span class="d-block">{{ \Carbon\Carbon::now(obtainTimezoneName($timezone ?? null))  }}</span>
            </div>
        </nav>
    </div>

    <div id="layoutSidenav_content">
        <main class="mb-5">
            @if (isset($breadcrumb) and $breadcrumb instanceof \App\Src\Shared\Presenter\Breadcrumb\Breadcrumb)
                @include('common.breadcrumb', ['breadcrumb' => $breadcrumb])
            @endif

            <div class="container-fluid">

                @impersonating()
                @include('common.impersonate_warning')
                @endImpersonating

                <div class="row mt-3">
                    <div class="col-12">
                        @include('flash::message')
                    </div>
                </div>

                @yield('content')

            </div>
        </main>
        <footer class="py-2 bg-light mt-auto">
            @include('common.footer_flat')
        </footer>
    </div>

</div>

@include('common.modal')
@include('common.javascript')
</body>
</html>
