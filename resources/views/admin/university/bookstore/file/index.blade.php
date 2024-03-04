@extends('layouts.app_pdf')

@section('content')


    @foreach ($request->code()->cursor() as $code)

        @include('admin.university.bookstore.file.page_code', [
            'request' => $code->request,
            'code' => $code
            ])

        @if ( ! $loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach


@endsection
