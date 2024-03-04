<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Linguameeting') }}</title>

<link href="https://fonts.googleapis.com/css2?family=Manrope&display=swap" rel="stylesheet">


<script src="https://code.jquery.com/jquery-3.6.3.min.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{asset('js/web/bootstrap/bootstrap.bundle.min.js')}}"></script>
<link href="{{asset('css/jquery-ui.min.css')}}" rel="stylesheet" />
<link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
<link href="{{asset('css/styles.css')}}" rel="stylesheet" />
<link href="{{asset('css/bootstrap-select.min.css')}}" rel="stylesheet" />
<link href="{{asset('js/fullcalendar/lib/main.min.css')}}" rel="stylesheet" />
<link href="{{asset('css/custom.css?v=1.17')}}" rel="stylesheet" />

@auth
    @if (user()->isInstructor())
        <link href="{{asset('css/instructor.css?v=1.1')}}" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
            integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
        <link href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.bootstrap5.min.css" rel="stylesheet">

    @endif
@endauth
