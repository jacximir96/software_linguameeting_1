@extends('layouts.app')

@section('content')

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-table me-1"></i>
                List of Coaches
            </span>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-12 col-xl-6">
                    <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                        <thead>
                        <tr>
                            <td class="w-5">#</td>
                            <th class="w-5">ID</th>
                            <th>Name</th>
                            <th>Active/Inactive</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($coaches as $coach)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    {{$coach->id}}
                                </td>
                                <td>
                                    <a href="{{route('get.admin.coach.show', $coach->hashId())}}" class="mr-2" title="Show coach">
                                        {{$coach->writeFullName()}}
                                    </a>
                                </td>
                                <td>
                                    {{Form::checkbox('active', 1, $coach->isActive(), [
                                                    'class' => 'form-check-input d-block change-status-user',
                                                    'data-change-url' => route('post.admin.api.users.status.change', $coach->hashId())
                                                    ])}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
