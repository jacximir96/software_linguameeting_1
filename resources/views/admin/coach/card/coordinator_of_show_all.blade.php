@extends('layouts.app_modal')

@section('content')

    <div class="row">


        <div class="col-12 table-responsive">
            @if ($coordinated->count())
            <table  class="table table-hover">
                <thead>
                <tr>
                    <th class="w-75">Coach</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($coordinated as $coachCoordinated)

                    <tr>
                        <td>
                            <a href="{{route('get.admin.coach.show', $coachCoordinated->coach_id)}}"
                               class="text-primary me-3" title="Show coach">
                                {{$coachCoordinated->coach->writeFullName()}}
                            </a>
                        </td>
                        <td>
                            <a  href="{{route('get.admin.coach.remove_coordinated', [$coach->hashId(), $coachCoordinated->coach_id])}}"
                                onclick="return confirm('Are you sure you want to delete this coach relationship?');"
                                title="Remove relationship ">
                                <i class="fa fa-times text-danger"></i>
                            </a>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
                {{$coordinated->render()}}
            @else
                <div class="bg-light p-2 rounded">
                    Este coach no es coordinador de ningún otro.
                </div>
            @endif
        </div>
    </div>

@endsection
