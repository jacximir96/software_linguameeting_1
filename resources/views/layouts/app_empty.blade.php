<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('common.head')
</head>
<body class="sb-nav-fixed">

<div id="layoutSidenav">

    <div id="layoutSidenav_content" class="ps-0 mt-0">
        <main class="mb-5">
            <div class="container-fluid">
                <div class="row mt-3">
                    <div class="col-12">
                        @include('flash::message')
                    </div>
                </div>
                @yield('content')
            </div>
        </main>
    </div>
</div>

@include('common.modal')
@include('common.javascript')
</body>
</html>
