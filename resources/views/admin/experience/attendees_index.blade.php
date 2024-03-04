@extends('layouts.app_modal')

@section('content')


    <div class="row">
        <div class="col-12 text-end">
            <a href="{{route('get.admin.experience.attendees.excel', $experience->id)}}" >
                <i class="fa fa-download"></i> Download Excel
            </a>
        </div>
        <div class="col-12">
            <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                <thead>
                <tr class="small">
                    <th>Last Name, Name</th>
                    <th>Email</th>
                </tr>
                </thead>

                <tbody>

                @forelse($experienceUsers as $experienceUser)

                    <tr>
                        <td>{{$experienceUser->user->writeFullName()}}</td>
                        <td>{{$experienceUser->user->email}}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">No users attendee</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{$experienceUsers->render()}}
        </div>
    </div>

@endsection
