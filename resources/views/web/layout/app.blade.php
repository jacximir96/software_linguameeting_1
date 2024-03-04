<!DOCTYPE html>
<html lang="en">
<head>
    @include('common.web.head')
</head>
<body>

    @include('common.web.header')
    <main>
        @yield('content')
    </main>
    @include('common.web.footer')
</body>
</html>
