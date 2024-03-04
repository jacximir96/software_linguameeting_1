@extends('layouts.app_modal')

@section('content')


    <div class="row">
        <div class="col-12">
            <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                <thead>
                <tr class="small">
                    <th>Origin</th>
                    <th class="w-20">Last Name, Name</th>
                    <th class="w-20">Email</th>
                    <th class="">Stars</th>
                    <th class="w-50">Comment</th>
                </tr>
                </thead>

                <tbody>

                @forelse($experienceComments as $experienceComment)
                    <tr>
                        <td>
                            @if ($experienceComment->user)
                               <span class="text-warning">Registered</span>
                            @else
                                <span class="text-success">Public</span>
                            @endif
                        </td>
                        <td>{{$experienceComment->writeFullName()}}</td>
                        <td>{{$experienceComment->writeEmail()}}</td>
                        <td>{{$experienceComment->stars}}</td>
                        <td>{{$experienceComment->comment}}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">No users attendee</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{$experienceComments->render()}}
        </div>
    </div>

@endsection
