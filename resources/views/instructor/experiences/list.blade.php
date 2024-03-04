@extends('layouts.app')

@section('content')

    <div class="container px-4">

        <div class="row">

            <div class="col-12 mt-4">
                @include('student.experience.features')
            </div>

            @if ($isUpcoming)
                <div class="col-12 mt-4 d-flex justify-content-between">

                    <span class="bg-corporate-color-light border p-1 fw-bold text-success">Showing Upcoming Experiences</span>

                    <a href="{{route('get.instructor.experiences.list', ['status' => 'past'])}}"
                       class="p-1 border fw-bold shadow-sm text-warning-dark-2"
                       title="Show past experiences">Show Past Experiences</a>

                </div>
            @else
                <div class="col-12 mt-4 d-flex justify-content-between">

                    <span class="p-1 border fw-bold shadow-sm bg-warning-soft text-warning-dark-2">Showing Past Experiences</span>

                    <a href="{{route('get.instructor.experiences.list')}}"
                       class="border p-1 fw-bold text-success"
                       title="Show Upcoming experiences">Show Upcoming Experiences</a>
                </div>

            @endif


            <div class="col-12 mt-2 mb-5">

                @foreach ($experiences as $experience)
                    @include('instructor.experiences.experience', ['experience' => $experience, 'user' => $instructor])
                @endforeach

                {{$experiences->render()}}

            </div>
        </div>

    </div>
@endsection
