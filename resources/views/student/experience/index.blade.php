@extends('layouts.app')

@section('content')

    <div class="container px-4">

        <div class="row">

            <div class="col-12 mt-4">
                @include('student.experience.features')
            </div>

            <div class="col-12 mt-4 d-flex justify-content-between">
                @if ($isUpcoming)
                    <span class="bg-corporate-color-light text-success fw-bold p-1">Showing Upcoming Experiences</span>
                    <a href="{{route('get.student.experience.index', ['status' => 'past'])}}" title="Show past experiences">Show Past Experiences</a>
                @else
                    <span class="bg-warning fw-bold p-1">Past Experiences</span>
                    <a href="{{route('get.student.experience.index')}}" title="Show upcoming experiences">Showing Upcoming Experiences</a>
                @endif

            </div>
            <div class="col-12 mt-2 mb-5">

                @foreach ($experiences as $experience)
                    @include('student.experience.experience', ['experience' => $experience])
                @endforeach

                {{$experiences->render()}}

            </div>
        </div>

    </div>
@endsection
