<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('common.head')
</head>
<body>

<div class="container-fluid" id="modal_container" style="height: 100% !important;">

    <div class="row">
        <div class="col-12">
            @include('flash::message')
        </div>
    </div>

    @yield('content')

</div>

@include('common.modal')
@include ('common.javascript')
</body>
</html>
