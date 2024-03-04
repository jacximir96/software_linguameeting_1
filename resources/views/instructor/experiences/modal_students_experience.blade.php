@extends('layouts.app_modal')

@section('content')


    <div class="row">
        <div class="col-12">
            <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                <thead>
                <tr>
                    <th class="w-30">Student</th>
                    <th class="w-40">Course</th>
                    <th class="w-30">Section</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($viewData->studentsList()->get() as $studentItem)

                    <tr>
                        <td>{{$studentItem->student()->writeFullName()}}</td>
                        <td>{{$studentItem->enrollment()->section->course->name}}</td>
                        <td>{{$studentItem->enrollment()->section->name}}</td>
                    </tr>
                @empty

                    <tr>
                        <td colspan="3">
                            <span class=" text-white bg-warning px-2 py-1 rounded ">No students registered</span>
                        </td>
                    </tr>

                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
