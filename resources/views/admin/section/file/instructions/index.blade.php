@extends('layouts.app_pdf')

@section('content')

    @include('common.file.head')

    <div class="content">

        @if ($viewData->isLingro ())

            @include('admin.section.file.instructions.lingro.header')

            @include('admin.section.file.instructions.lingro.info')

            @include('admin.section.file.instructions.lingro.steps')
        @else

            @include('admin.section.file.instructions.lingua.header')

            @include('admin.section.file.instructions.lingua.info')

            @include('admin.section.file.instructions.lingua.steps')

            @include('admin.section.file.instructions.lingua.info_cancel')
        @endif

        @include('admin.section.file.instructions.support')
    </div>
@endsection
