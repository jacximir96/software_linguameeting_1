@extends('layouts.app')

@section('content')

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-tasks me-1"></i>
                Instructor Feedback
            </span>
            <span>{{$timezone->name}}</span>

        </div>
        <div class="card-body">

            <div class="row">

                <div class="col-12 col-xl-8">


                    <table id="" class="table table-hover">
                        <thead>
                        <tr>
                            <th class="w-30">Instructor</th>
                            <th class="w-10">Date</th>
                            <th class="w-60">Content</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($evaluations as $evaluation)

                            <tr>

                                <td>
                                    <span class="fw-bold d-block">{!! $evaluation->instructor->writeFullName() !!}</span>
                                    <span class="d-block">{{ $evaluation->instructor->university->first()->name }}</span>
                                </td>

                                <td>
                                    {!! toDatetimeInOneRow($evaluation->evaluation_at, $timezone) !!}
                                </td>
                                <td>
                                    {!! $evaluation->content !!}
                                </td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                    {{$evaluations->render()}}
                </div>
            </div>
        </div>
    </div>
@endsection
