@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found'))

@section('content')
    <div style="margin-top:30px">
        <a href="{{route('home')}}" style="color:blue">Go Home</a>
    </div>

@endsection
