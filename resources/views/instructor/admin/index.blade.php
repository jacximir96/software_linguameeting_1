@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <span class="text-corporate-dark-color box_sessions_tag"><strong>Instructor List </strong></span>
    </div>
</div>

<div class="card float-none margin-top-10 card-list-courses-instructor">

    <div class="card-body">

        <div class="row">
            <div class="col-12 mb-3">
                <a class="a-title text-corporate-color" href="#"><u>Download list</u></a>
            </div>
        </div>

        <table id="table-instructor" class="table" data-paging="false" data-searching="false" data-ordering="false">
            <thead>
                <tr>
                    <th class="">
                        NAME
                    </th>
                    <th class="">LAST NAME</th>
                    <th class="">EMAIL</th>
                    <th>ROLE</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>

            <tbody>
                
                <!-- href="{{route('get.admin.course.coaching_form.create.update.academic_dates', 555)}}-->
                @foreach($instructors as $instructor)
                <tr>
                    <td>{{$instructor->name}}</td>
                    <td>{{$instructor->lastname}}</td>
                    <td class="text-corporate-color">{{$instructor->email}}</td>
                    <td>
                        @if ($instructor->role_id == 4)
							<span class="color5 text_bold">Coordinator</span>
                        @elseif ($instructor->role_id == 5)
							Instructor
                        @elseif ($instructor->role_id == 6)
							<span class="color12">Instructor Assistant</span>
						@else
							<span class="color7">Course Manager</span>
                        @endif
                    </td>

                    <td>
                        <select class="form-select form-select-sm actionsChange" aria-label=".form-select-sm example">
                            <option value="">Actions </option>
                            <option value="{{route('get.instructor.admin.edit', $instructor->hashId())}}" 
                                    class="open-modal validation-modal" 
                                    data-modal-reload="yes" 
                                    data-reload-type="parent" 
                                    data-modal-title='Edit Instructor' 
                                    title="Edit instructor">Edit Info                        
                            </option>
                            <option value="{{route('get.instructor.admin.delete', $instructor->hashId())}}"
                                class="open-modal validation-modal"
                                data-modal-reload="yes"
                                data-reload-type="parent"
                                data-modal-title="Delete Instructor"
                                title="Delete Instructor">
                                Delete
                            </option>
                        </select>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>


@endsection
