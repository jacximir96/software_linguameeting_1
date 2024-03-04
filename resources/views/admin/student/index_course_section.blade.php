@extends('layouts.app_modal')

@section('content')


    <div class="row d-none d-sm-block">
        <div class="col-12">
            <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                <thead>
                <tr class="small">
                    <th class="">Student ID</th>
                    <th>Last Name, Name</th>
                    <th>Email</th>
                    <th>Registered at</th>
                </tr>
                </thead>

                <tbody>
                @php $sectionId = '' @endphp
                @forelse($enrollments as $enrollment)

                    @if ($enrollment->section_id != $sectionId)
                        <tr class="bg-corporate-color-lighter">
                            <td colspan="4">
                                {{$enrollment->section->name}}
                            </td>
                        </tr>
                        @php $sectionId = $enrollment->section_id @endphp
                    @endif

                    <tr>
                        <td>{{$enrollment->user->id}}</td>
                        <td>
                            <a href="{{route('get.admin.student.show', $enrollment->student_id)}}" target="_blank" class="mr-2" title="Show student">
                                {{$enrollment->user->writeFullName()}}
                            </a>

                            @include('admin.student.accommodation.link', ['enrollment' => $enrollment])
                        </td>
                        <td>{{$enrollment->user->email}}</td>
                        <td>{{$enrollment->status_at->format('m/d/Y H:i:s')}}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">No students registered</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{$enrollments->render()}}
        </div>
    </div>

    <div class="row d-block d-sm-none">

        <div class="col-12">
            @if ($enrollments->count())
                <ul>
                    @foreach ($enrollments as $enrollment)
                        <li>
                            <span class="d-block">{{$enrollment->user->id}}</span>
                            <span class="d-block">{{$enrollment->user->writeFullName()}}</span>
                            <span class="d-block">{{$enrollment->user->email}}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <span class=" text-white bg-warning px-2 py-1 rounded ">No students registered</span>
            @endif
        </div>

    </div>

@endsection
